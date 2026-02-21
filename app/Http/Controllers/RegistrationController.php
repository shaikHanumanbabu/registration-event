<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    /**
     * Display a listing of registrations
     */
    public function index()
    {
        $registrations = Registration::orderBy('created_at', 'desc')->paginate(10);
        return view('registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new registration
     */
    public function create()
    {

        return view('registrations.create');
    }

    /**
     * Store a newly created registration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_type' => 'required|in:new,existing',
            'family_included' => 'required|in:yes,no',
            'adults_count' => 'nullable|integer|min:0',
            'child_count' => 'nullable|integer|min:0',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'state' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'payment_type' => 'required|in:phonepe,gpay,others',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');
            $filename = time() . '_' . $file->getClientOriginalName();
            $publicPath = public_path('images/payment_receipts/' . $filename);
            // Create directory if not exists
            if (!file_exists(dirname($publicPath))) {
                mkdir(dirname($publicPath), 0755, true);
            }
            $file->move(dirname($publicPath), $filename);
            $validated['payment_receipt'] = 'images/payment_receipts/' . $filename;
        }

        // Create registration
        /* $registration = Registration::create($validated);

         // Generate QR code for this registration
        $qrData = "Registration ID: {$registration->id}\n";
        $qrData .= "Customer No: {$registration->customer_no}\n";
        $qrData .= "Name: {$registration->name}\n";
        $qrData .= "Email: {$registration->email}\n";
        $qrData .= "Amount: ₹{$registration->total_amount}";

        $qrCodePath = 'qr_codes/registration_' . $registration->id . '.png';
        
        // Generate and save QR code
        $qrCode = QrCode::format('png')
            ->size(300)
            ->generate($qrData);
        
        Storage::disk('public')->put($qrCodePath, $qrCode); */

        // Create registration
        $registration = Registration::create($validated);

        // Generate QR code for this registration with verification URL
        $verificationUrl = route('verify-checkin', ['id' => $registration->id]);
        $qrData = $verificationUrl;

        $qrCodePath = 'images/qr_codes/registration_' . $registration->id . '.png';
        $qrCodePublicPath = public_path($qrCodePath);

        // Create directory if it doesn't exist
        if (!file_exists(dirname($qrCodePublicPath))) {
            mkdir(dirname($qrCodePublicPath), 0755, true);
        }

        // Use GDLibImageBackEnd for PNG output (no imagick required)
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(300),
            new \BaconQrCode\Renderer\Image\GDLibImageBackEnd()
        );

        $writer = new \BaconQrCode\Writer($renderer);
        $qrCode = $writer->writeString($qrData, 'UTF-8');

        // Store directly in public folder
        file_put_contents($qrCodePublicPath, $qrCode);

        // Update registration with QR code path
        $registration->update(['qr_code' => $qrCodePath]);

        // Send registration testing email
        try {
            Mail::send('emails.registration-success', [
                'registration' => $registration,
            ], function ($message) use ($registration) {
                $message->to($registration->email)
                    ->subject('Registration Confirmation - ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            Log::error('Failed to send registration email: ' . $e->getMessage());
        }

        return redirect()->route('registrations.create')
            ->with('success', 'Registration created successfully! Customer Number: ' . $registration->customer_no);
    }

    /**
     * Display the specified registration
     */
    public function show(Registration $registration)
    {
        return view('registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified registration
     */
    public function edit(Registration $registration)
    {
        return view('registrations.edit', compact('registration'));
    }

    /**
     * Update the specified registration
     */
    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'customer_type' => 'required|in:new,existing',
            'family_included' => 'required|in:yes,no',
            'adults_count' => 'nullable|integer|min:0',
            'child_count' => 'nullable|integer|min:0',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'state' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:phonepe,gpay,others',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('payment_receipt')) {
            // Delete old receipt if exists
            if ($registration->payment_receipt) {
                Storage::disk('public')->delete($registration->payment_receipt);
            }

            $file = $request->file('payment_receipt');
            $filename = time() . '_' . $file->getClientOriginalName();
            $publicPath = public_path('images/payment_receipts/' . $filename);
            // Create directory if not exists
            if (!file_exists(dirname($publicPath))) {
                mkdir(dirname($publicPath), 0755, true);
            }
            $file->move(dirname($publicPath), $filename);
            $validated['payment_receipt'] = 'images/payment_receipts/' . $filename;
        }

        $registration->update($validated);

        return redirect()->route('registrations.index')
            ->with('success', 'Registration updated successfully!');
    }

    /**
     * Remove the specified registration
     */
    public function destroy(Registration $registration)
    {
        // Delete associated files
        if ($registration->payment_receipt) {
            Storage::disk('public')->delete($registration->payment_receipt);
        }
        if ($registration->qr_code) {
            $qrCodePath = public_path($registration->qr_code);
            if (file_exists($qrCodePath)) {
                unlink($qrCodePath);
            }
        }

        $registration->delete();

        return redirect()->route('registrations.index')
            ->with('success', 'Registration deleted successfully!');
    }

    /**
     * Show verification and check-in details
     */
    public function verifyCheckin($id)
    {
        $registration = Registration::findOrFail($id);
        return view('registrations.verify-checkin', compact('registration'));
    }

    /**
     * Mark registration as checked in
     */
    public function confirmCheckin($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update(['payment_status' => 'verified', 'checked_in' => true, 'checked_in_at' => now()]);

        return redirect()->route('verify-checkin', ['id' => $id])
            ->with('success', 'Check-in verified successfully!');
    }
}

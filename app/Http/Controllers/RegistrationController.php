<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

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
            'total_amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:phonepe,gpay,others',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payment_receipts', $filename, 'public');
            $validated['payment_receipt'] = $path;
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

        // Generate QR code for this registration
        $qrData = "Registration ID: {$registration->id}\n";
        $qrData .= "Customer No: {$registration->customer_no}\n";
        $qrData .= "Name: {$registration->name}\n";
        $qrData .= "Email: {$registration->email}\n";
        $qrData .= "Amount: ₹{$registration->total_amount}";
/* 
        $qrCodePath = 'qr_codes/registration_' . $registration->id . '.png';

        // Use BaconQrCode directly with PNG renderer and UTF-8 encoding
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(300),
            new \BaconQrCode\Renderer\Image\EpsImageBackEnd()
        );

        $writer = new \BaconQrCode\Writer($renderer);

        // Use UTF-8 encoding options
        $qrCode = $writer->writeString(
            $qrData,
            'UTF-8'
        );

        Storage::disk('public')->put($qrCodePath, $qrCode); */


        $qrCodePath = 'qr_codes/registration_' . $registration->id . '.svg';

        // Use SVG backend - works without any extensions
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(300),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );

        $writer = new \BaconQrCode\Writer($renderer);
        $qrCode = $writer->writeString($qrData, 'UTF-8');

        Storage::disk('public')->put($qrCodePath, $qrCode);
        
        // Update registration with QR code path
        $registration->update(['qr_code' => $qrCodePath]);

        return redirect()->route('registrations.index')
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
            $path = $file->storeAs('payment_receipts', $filename, 'public');
            $validated['payment_receipt'] = $path;
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
            Storage::disk('public')->delete($registration->qr_code);
        }

        $registration->delete();

        return redirect()->route('registrations.index')
            ->with('success', 'Registration deleted successfully!');
    }
}

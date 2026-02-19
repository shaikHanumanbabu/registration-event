<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('registrations.create');
});

Route::resource('registrations', RegistrationController::class);

// Route to check registration success email with static data
Route::get('/check-registration-mail', function () {
    $registration = (object) [
        'id' => 10001,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '9876543210',
        'customer_type' => 'new',
        'family_included' => 'yes',
        'adults_count' => 2,
        'child_count' => 1,
        'total_amount' => 1300.00,
        'address' => '123 Main Street',
        'state' => 'California',
    ];

    $qrCodePath = 'images/payment-qr2.png';

    return view('emails.registration-success', [
        'registration' => $registration,
        'qrCodePath' => $qrCodePath,
    ]);
})->name('check.registration-mail');

// Route to send registration email using Google SMTP
Route::get('/send-registration-email', function () {
    try {
        $registration = (object) [
            'id' => 10001,
            'name' => 'John Doe',
            'email' => 'hanumanbabu.shaik@yopmail.com',
            'phone' => '9876543210',
            'customer_type' => 'new',
            'family_included' => 'yes',
            'adults_count' => 2,
            'child_count' => 1,
            'total_amount' => 1300.00,
            'address' => '123 Main Street',
            'state' => 'California',
        ];

        $qrCodePath = 'images/payment-qr2.png';

        // Send email using Laravel's Mail facade
        \Illuminate\Support\Facades\Mail::send('emails.registration-success', [
            'registration' => $registration,
            'qrCodePath' => $qrCodePath,
        ], function ($message) use ($registration) {
            $message->to($registration->email)
                ->subject('Event Registration Successful - ' . config('app.name'))
                ->from(config('mail.from.address'), config('mail.from.name'));
        });

        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully to ' . $registration->email
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
})->name('send.registration-email');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (without middleware)
    Route::get('/login', [App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'login']);

    // Protected routes (with middleware)
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
        Route::post('/registrations/{id}/verify-payment', [App\Http\Controllers\AdminController::class, 'verifyPayment'])->name('verify-payment');
        Route::post('/registrations/{id}/unverify-payment', [App\Http\Controllers\AdminController::class, 'unverifyPayment'])->name('unverify-payment');
    });
});

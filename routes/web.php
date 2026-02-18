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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_no',
        'customer_type',
        'family_included',
        'adults_count',
        'child_count',
        'name',
        'email',
        'phone',
        'address',
        'state',
        'notes',
        'total_amount',
        'payment_type',
        'payment_receipt',
        'payment_status',
        'qr_code',
        'checked_in',
        'checked_in_at'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'adults_count' => 'integer',
        'child_count' => 'integer',
        'checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    /**
     * Generate unique customer number
     */
    public static function generateCustomerNumber()
    {
        $prefix = 'CUST';
        $year = date('Y');

        // Get the last customer number for this year
        $lastRegistration = self::where('customer_no', 'LIKE', $prefix . $year . '%')
            ->orderBy('customer_no', 'desc')
            ->first();

        if ($lastRegistration) {
            $lastNumber = intval(substr($lastRegistration->customer_no, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $year . $newNumber;
    }

    /**
     * Boot method to auto-generate customer number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->customer_no)) {
                $registration->customer_no = self::generateCustomerNumber();
            }
        });
    }
}

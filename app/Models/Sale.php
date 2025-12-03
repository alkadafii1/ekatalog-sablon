<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'customer_name',
        'customer_contact',
        'total_amount',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'transaction_date' => 'date', // supaya ->format() aman
        'total_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public static function generateTransactionNumber()
    {
        $date = now()->format('Ymd');
        $lastSale = static::where('transaction_number', 'like', "INV-{$date}-%")
                          ->latest('id')
                          ->first();

        $number = $lastSale ? (int) substr($lastSale->transaction_number, -4) + 1 : 1;

        return "INV-{$date}-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}

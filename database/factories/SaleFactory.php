<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        static $counter = 1; // supaya selalu unik

        $transactionNumber = 'INV-' . now()->format('Ymd') . '-' . str_pad($counter++, 4, '0', STR_PAD_LEFT);

        return [
            'transaction_number' => $transactionNumber,
            'transaction_date' => $this->faker->date(),
            'customer_name' => $this->faker->name(),
            'customer_contact' => $this->faker->phoneNumber(),
            'total_amount' => 0,
            'payment_method' => $this->faker->randomElement(['cash','transfer','qris','debit_card','credit_card']),
            'payment_status' => $this->faker->randomElement(['paid','pending']),
            'notes' => $this->faker->sentence(),
        ];
    }
}

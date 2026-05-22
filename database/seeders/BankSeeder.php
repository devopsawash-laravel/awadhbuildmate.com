<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [

            'State Bank of India (SBI)',
            'Bank of Baroda',
            'Punjab National Bank (PNB)',
            'Canara Bank',
            'Union Bank of India',
            'Indian Bank',
            'Bank of India',
            'Central Bank of India',
            'UCO Bank',
            'Bank of Maharashtra',
            'Punjab & Sind Bank',
            'Indian Overseas Bank',

            'HDFC Bank',
            'ICICI Bank',
            'Axis Bank',
            'Kotak Mahindra Bank',
            'IndusInd Bank',
            'Yes Bank',
            'IDFC FIRST Bank',
            'Federal Bank',
            'South Indian Bank',
            'RBL Bank',
            'Bandhan Bank',

            'Airtel Payments Bank',
            'India Post Payments Bank',
            'Paytm Payments Bank',

            'AU Small Finance Bank',
            'Ujjivan Small Finance Bank',
            'Equitas Small Finance Bank',
            'Jana Small Finance Bank',
        ];

        foreach ($banks as $bank) {

            Bank::create([
                'bank_name' => $bank
            ]);
        }
    }
}
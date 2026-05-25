<?php

namespace Database\Seeders;

use App\Models\Labour;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            BankSeeder::class,
            SiteSeeder::class,
            LabourSeeder::class,

        ]);
    }   
}

   

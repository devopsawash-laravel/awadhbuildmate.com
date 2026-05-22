<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    \App\Models\Site::insert([

        [
        'name' => 'Dahej Refinery Project',
        'slug' => 'dahej-refinery-project',
        'location' => 'Dahej, Gujarat',
        'state' => 'Gujarat',
        'client' => 'HPCL',
        'status' => 'active',
        'start_date' => '2026-01-10',
        'expected_end_date' => '2026-12-31',
        'description' => 'Structural fabrication and erection work.',
        'site_incharge' => 'Rakesh Sharma',
        'incharge_phone' => '9876543210',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Mundra Port Expansion',
        'slug' => 'mundra-port-expansion',
        'location' => 'Mundra, Gujarat',
        'state' => 'Gujarat',
        'client' => 'Adani Ports',
        'status' => 'active',
        'start_date' => '2026-02-15',
        'expected_end_date' => '2027-03-20',
        'description' => 'Heavy structural fabrication and erection work.',
        'site_incharge' => 'Vijay Patel',
        'incharge_phone' => '9825012345',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Panipat IOCL Project',
        'slug' => 'panipat-iocl-project',
        'location' => 'Panipat, Haryana',
        'state' => 'Haryana',
        'client' => 'IOCL',
        'status' => 'active',
        'start_date' => '2026-03-01',
        'expected_end_date' => '2027-01-31',
        'description' => 'Industrial pipeline and steel structure erection.',
        'site_incharge' => 'Amit Verma',
        'incharge_phone' => '9811122233',
        'created_at' => now(),
        'updated_at' => now(),
    ],
     [
        'name' => 'Jamnagar Petrochemical Unit',
        'slug' => 'jamnagar-petrochemical-unit',
        'location' => 'Jamnagar, Gujarat',
        'state' => 'Gujarat',
        'client' => 'Reliance Industries',
        'status' => 'active',
        'start_date' => '2026-04-10',
        'expected_end_date' => '2027-05-25',
        'description' => 'Petrochemical plant structural fabrication.',
        'site_incharge' => 'Sanjay Yadav',
        'incharge_phone' => '9898989898',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Hazira LNG Terminal',
        'slug' => 'hazira-lng-terminal',
        'location' => 'Hazira, Gujarat',
        'state' => 'Gujarat',
        'client' => 'Shell',
        'status' => 'completed',
        'start_date' => '2025-01-05',
        'expected_end_date' => '2025-12-20',
        'description' => 'LNG terminal maintenance and structural work.',
        'site_incharge' => 'Mukesh Chauhan',
        'incharge_phone' => '9767676767',
        'created_at' => now(),
        'updated_at' => now(),
    ],
       [
        'name' => 'Vizag Steel Plant',
        'slug' => 'vizag-steel-plant',
        'location' => 'Visakhapatnam, Andhra Pradesh',
        'state' => 'Andhra Pradesh',
        'client' => 'Vizag Steel',
        'status' => 'active',
        'start_date' => '2026-05-01',
        'expected_end_date' => '2027-02-28',
        'description' => 'Steel structure and fabrication work.',
        'site_incharge' => 'Rahul Singh',
        'incharge_phone' => '9700011122',
        'created_at' => now(),
        'updated_at' => now(),
    ],
     [
        'name' => 'Bina Refinery Shutdown',
        'slug' => 'bina-refinery-shutdown',
        'location' => 'Bina, Madhya Pradesh',
        'state' => 'Madhya Pradesh',
        'client' => 'BPCL',
        'status' => 'inactive',
        'start_date' => '2025-11-15',
        'expected_end_date' => '2026-06-30',
        'description' => 'Shutdown maintenance structural activities.',
        'site_incharge' => 'Deepak Kumar',
        'incharge_phone' => '9755512345',
        'created_at' => now(),
        'updated_at' => now(),
    ],
     [
        'name' => 'Kandla Warehouse Project',
        'slug' => 'kandla-warehouse-project',
        'location' => 'Kandla, Gujarat',
        'state' => 'Gujarat',
        'client' => 'DP World',
        'status' => 'active',
        'start_date' => '2026-06-01',
        'expected_end_date' => '2026-12-15',
        'description' => 'Warehouse fabrication and roofing work.',
        'site_incharge' => 'Rohit Sharma',
        'incharge_phone' => '9888877777',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    ]);
}
}

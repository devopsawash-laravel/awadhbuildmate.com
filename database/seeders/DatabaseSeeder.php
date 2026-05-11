<?php

namespace Database\Seeders;

use App\Models\Labour;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $labours = [
            ['name' => 'Ramesh Kumar',    'employee_id' => 'EMP-001', 'category' => 'Welder',  'phone' => '9876543210', 'daily_wage' => 800,  'overtime_rate' => 150, 'pf_percentage' => 12],
            ['name' => 'Suresh Patel',    'employee_id' => 'EMP-002', 'category' => 'Fitter',  'phone' => '9876543211', 'daily_wage' => 750,  'overtime_rate' => 120, 'pf_percentage' => 12],
            ['name' => 'Mahesh Singh',    'employee_id' => 'EMP-003', 'category' => 'Helper',  'phone' => '9876543212', 'daily_wage' => 500,  'overtime_rate' => 90,  'pf_percentage' => 12],
            ['name' => 'Rajesh Yadav',    'employee_id' => 'EMP-004', 'category' => 'Rigger',  'phone' => '9876543213', 'daily_wage' => 900,  'overtime_rate' => 180, 'pf_percentage' => 12],
            ['name' => 'Sanjay Mehta',    'employee_id' => 'EMP-005', 'category' => 'Welder',  'phone' => '9876543214', 'daily_wage' => 850,  'overtime_rate' => 160, 'pf_percentage' => 12],
            ['name' => 'Vijay Sharma',    'employee_id' => 'EMP-006', 'category' => 'Fitter',  'phone' => '9876543215', 'daily_wage' => 780,  'overtime_rate' => 130, 'pf_percentage' => 12],
            ['name' => 'Amit Kumar',      'employee_id' => 'EMP-007', 'category' => 'Helper',  'phone' => '9876543216', 'daily_wage' => 550,  'overtime_rate' => 100, 'pf_percentage' => 12],
        ];

        foreach ($labours as $labour) {
            Labour::create(array_merge($labour, [
                'joining_date' => '2024-01-01',
                'status' => 'active',
                'address' => 'Ankleshwar, Gujarat'
            ]));
        }
    }
}
   
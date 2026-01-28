<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auditor;

class AuditorSeeder extends Seeder
{
    public function run(): void
    {
        Auditor::create([
            'name' => 'Mr. Ahsan Karim',
            'auditor_code' => 'AUD-001',
            'phone' => '01711111111',
            'email' => 'ahsan@example.com',
            'status' => 1,
            'priority' => 1,
            'auditor_details_box' => 'Senior Auditor',
        ]);

        Auditor::create([
            'name' => 'Ms. Nabila Islam',
            'auditor_code' => 'AUD-002',
            'phone' => '01822222222',
            'email' => 'nabila@example.com',
            'status' => 1,
            'priority' => 2,
            'auditor_details_box' => 'Field Auditor',
        ]);

        Auditor::create([
            'name' => 'Mr. Tanvir Rahman',
            'auditor_code' => 'AUD-003',
            'phone' => '01933333333',
            'email' => 'tanvir@example.com',
            'status' => 0,
            'priority' => 3,
            'auditor_details_box' => 'Junior Auditor',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'employeeName' => 'budi',
            'email' => 'budi@example.com',
            'password' => bcrypt('123'),
            'DOB' => '1999-01-01',
            'noTelp' => '08221212',
            'employeeAddress' => 'Jln Kuningan',
            'gender' => 'M',
            'companyId' => 1,
            'positionId' => 1,
        ]);
    }
}

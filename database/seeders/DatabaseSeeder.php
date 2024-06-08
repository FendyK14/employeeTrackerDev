<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $companies = Company::factory()->count(2)->create();
        $this->call([
            // CompanySeeder::class,
            PositionSeeder::class,
            UserSeeder::class,
            // EmployeeSeeder::class
        ]);

        // $positions = Position::all();

        // Employee::factory()->count(50)->create([
        //     'companyId' => $companies->random()->id,
        //     'positionId' => $positions->random()->positionId,
        // ]);
    }
}

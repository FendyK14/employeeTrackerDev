<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'positionId' => 1,
            'positionName' => 'HR'
        ]);

        // Menetapkan posisi PM (Project Manager)
        Position::create([
            'positionId' => 2,
            'positionName' => 'PM'
        ]);
    }
}

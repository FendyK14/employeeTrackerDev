<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Database\Seeders\PositionSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $positionsCount = Position::count();
        return [
            'employeeName' => $this->faker->name(),
            'DOB' => $this->faker->date(),
            'employeeEmail' => $this->faker->unique()->safeEmail(),
            'noTelp' => substr($this->faker->phoneNumber(), 0, 15),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'employeeAddress' => $this->faker->address(),
            'companyId' => Company::all()->random()->id,
            'positionId' => Position::class,
            // 'email_verified_at' => now(),
            'password' => bcrypt('password'), // atau Anda bisa menggunakan password yang dienkripsi
        ];
    }
}

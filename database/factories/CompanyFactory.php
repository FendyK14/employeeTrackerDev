<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'companyName' => $this->faker->company(),
            'companyEmail' => $this->faker->unique()->safeEmail(),
            'companyPhone' => substr($this->faker->phoneNumber(), 0, 15),
            'companyAddress' => $this->faker->address(),
        ];
    }
}

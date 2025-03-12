<?php

namespace Database\Factories;

use App\Models\Cities;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = Cities::class;

    public function definition(): array
    {
        return [
            'fullname' => $this->faker->city,
        ];
    }
}

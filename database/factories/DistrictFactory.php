<?php

namespace Database\Factories;

use App\Models\Cities;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistrictFactory extends Factory
{
    protected $model = District::class;

    public function definition(): array
    {
        return [
            'fullname' => $this->faker->citySuffix,
            'city_id' => Cities::inRandomOrder()->first()->id
        ];
    }
}

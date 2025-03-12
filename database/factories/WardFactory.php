<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Factories\Factory;

class WardFactory extends Factory
{
    protected $model = Ward::class;

    public function definition(): array
    {
        return [
            'fullname' => $this->faker->streetName,
            'district_id' => District::inRandomOrder()->first()->id
        ];
    }
}

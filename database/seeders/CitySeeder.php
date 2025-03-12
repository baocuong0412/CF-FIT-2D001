<?php

namespace Database\Seeders;

use App\Models\Cities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get('https://provinces.open-api.vn/api/?depth=1');

        if ($response->successful()) {
            $cities = $response->json();
            foreach ($cities as $city) {
                Cities::create([
                    'id' => $city['code'], // Sử dụng đúng ID từ API
                    'fullname' => $city['name']
                ]);
            }
        }
    }
}

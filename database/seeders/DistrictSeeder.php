<?php

namespace Database\Seeders;

use App\Models\Cities;
use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $cities = Cities::all();

        foreach ($cities as $city) {
            $response = Http::get("https://provinces.open-api.vn/api/p/{$city->id}?depth=2");

            if ($response->successful()) {
                $data = $response->json();
                foreach ($data['districts'] as $district) {
                    District::create([
                        'id' => $district['code'], // Sử dụng đúng ID từ API
                        'fullname' => $district['name'],
                        'city_id' => $city->id
                    ]);
                }
            }
        }
    }
}

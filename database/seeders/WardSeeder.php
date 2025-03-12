<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Ward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $districts = District::all();

        foreach ($districts as $district) {
            $response = Http::get("https://provinces.open-api.vn/api/d/{$district->id}?depth=2");

            if ($response->successful()) {
                $data = $response->json();
                foreach ($data['wards'] as $ward) {
                    Ward::create([
                        'id' => $ward['code'], // Sử dụng đúng ID từ API
                        'fullname' => $ward['name'],
                        'district_id' => $district->id
                    ]);
                }
            }
        }
    }
}

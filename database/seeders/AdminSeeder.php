<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->create([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL', 'admin123@example.com'),
            'password' =>  Hash::make(env('ADMIN_PASSWORD', 'Timphong@123')),
        ]);
    }
}

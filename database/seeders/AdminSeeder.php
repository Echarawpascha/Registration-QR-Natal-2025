<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@christmas2025.com',
            'password' => 'admin123', // Will be hashed by mutator
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
        ]);
    }
}

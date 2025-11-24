<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name'=> 'admin',
                'email'=> 'admin@gmail.com',
                'password'=> bcrypt('admin123'),
                'role' => 'admin'
            ]);
        }
    }
}

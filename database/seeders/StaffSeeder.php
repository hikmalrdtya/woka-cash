<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (!User::where('role', 'staff')->exists()) {
            User::create([
                'name'=> 'Aqmal',
                'email'=> 'aqmal@gmail.com',
                'password'=> bcrypt('aqmal123'),
                'role' => 'staff'
            ]);
        }
    }
}

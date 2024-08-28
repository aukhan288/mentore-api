<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => 1, // Replace with the appropriate role_id for admin
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'dob' => '1980-01-01', // Replace with actual date of birth
            'country_code' => '+92',
            'contact' => '1234567890',
            'plate_form' => 'web', // Replace with actual platform value
            'ip_address' => '127.0.0.1',
            'password' => Hash::make('Admin12#'), // Replace with a strong password
            'remember_token' => Str::random(10),
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

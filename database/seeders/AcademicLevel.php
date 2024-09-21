<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicLevel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('academic_levels')->insert([
            [
             'name' => 'A-Level / College',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Undergraduate / Diploma',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Master',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'PhD',
             'created_at' => now(),
             'updated_at' => now(),
            ],
           
        ]);
    }
}

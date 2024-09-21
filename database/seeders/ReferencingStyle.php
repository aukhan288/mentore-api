<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferencingStyle extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('referencing_styles')->insert([
            [
             'name' => 'APA Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'CBE Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Chicago Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Harvard Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'MLA Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Oxford Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Turabian Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Vancouver Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            [
             'name' => 'Other Referencing',
             'created_at' => now(),
             'updated_at' => now(),
            ]
        ]);
    }
}

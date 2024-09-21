<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class services extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
              'name' => 'Assignment Reference',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Coursework Writing',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'CV or Resume Writing Services',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Dissertation & Thesis',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Essay Writing Tips',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Homework Help Services',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Online Exam',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Personal Statement',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'PowerPoint Presentation',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Research Paper',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Report Writing',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            [
              'name' => 'Research Proposal Services',
              'created_at' => now(),
              'updated_at' => now(),
            ]
        ]);
    }
}

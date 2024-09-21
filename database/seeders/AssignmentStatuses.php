<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentStatuses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'pending',
                'color' => '#FFF82A',
            ],
            [
                'name' => 'accepted',
                'color' => '#0040FF',
            ],
            [
                'name' => 'rejected',
                'color' => '#FF4B4B',
            ],
            [
                'name' => 'in-progress',
                'color' => '#4BFFFF',
            ],
            [
                'name' => 'completed',
                'color' => '#00b740',
            ],
        ];

        DB::table('assignment_statuses')->insert($data);
    }
}

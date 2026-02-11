<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['title' => 'CEO', 'code' => 'CEO', 'level' => 'Executive'],
            ['title' => 'Manager', 'code' => 'MGR', 'level' => 'Management'],
            ['title' => 'Senior Developer', 'code' => 'SR-DEV', 'level' => 'Senior'],
            ['title' => 'Developer', 'code' => 'DEV', 'level' => 'Mid'],
            ['title' => 'Junior Developer', 'code' => 'JR-DEV', 'level' => 'Junior'],
            ['title' => 'HR Specialist', 'code' => 'HR-SPEC', 'level' => 'Mid'],
            ['title' => 'Accountant', 'code' => 'ACC', 'level' => 'Mid'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            ['id' => 1, 'name' => '机械', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => '电控', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => '视觉', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => '宣传', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => '运营', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => '项目', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => '信息', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

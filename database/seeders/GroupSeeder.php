<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 4; $i++) {
            DB::table('groups')->insert([
                'name' => 'group ' . $i,
                'vk_id' => rand(100000, 999999),
                'alias' => Str::limit(Str::uuid(), '10', ''),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class DeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('decks')->insert([
            'id' =>1,
            'user_id' =>1,
            'category_id' =>1,
            'title' => '第1課（文字編）',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'deleted_at' => null,
        ]);
        //
        DB::table('decks')->insert([
            'id' =>2,
            'user_id' =>1,
            'category_id' =>1,
            'title' => '第2課（文字編）',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'deleted_at' => null,
        ]);
    }
}

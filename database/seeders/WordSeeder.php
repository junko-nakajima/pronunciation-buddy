<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('words')->insert([
            'deck_id' =>1,
            'word' => '아이',
            'meaning' => 'こども',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('words')->insert([
            'deck_id' =>1,
            'word' => '오이',
            'meaning' => 'きゅうり',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('words')->insert([
            'deck_id' =>1,
            'word' => '우유',
            'meaning' => '牛乳',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);     
    }
}

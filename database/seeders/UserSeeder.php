<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '先生1',
            'email' => 'nakasu0330@hotmail.com',
            'email_verified_at' => new DateTime(),
            'password' => 'laraveltest',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
     ]);
        //
    }
}

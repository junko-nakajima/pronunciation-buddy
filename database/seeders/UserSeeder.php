<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '先生3',
            'email' => 'nakasu0330@gmail.com',
            'email_verified_at' => new DateTime(),
            'password'  => Hash::make('laraveltest'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
     ]);
        //
    }
}

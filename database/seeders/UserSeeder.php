<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => 'Sobri Waskito Aji',
        //     'email' => 'wajisobri@gmail.com',
        //     'phone' => '081222954662',
        //     'password' => Hash::make('password'),
        // ]);
    }
}

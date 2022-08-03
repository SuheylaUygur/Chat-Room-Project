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
        DB::table('users')->insert([
            'fname'=>"Suheyla",
            'lname'=>'Uygur',
            'email'=>'suheyla.uygur@ceng.deu.edu.tr',
            'username'=>'suheyla.uygur',
            'password'=>Hash::make('1835*Wxyz'),
        ],
        [
            'fname'=>"Hello",
            'lname'=>'Hi',
            'email'=>'suygur99@hotmail.com',
            'username'=>'hello.hi',
            'password'=>Hash::make('1835*Wxyz')
        ]);
    }
}

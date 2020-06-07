<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'derek',
            'email' => 'derek@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
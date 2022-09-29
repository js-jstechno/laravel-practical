<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Test User 1', 'email' => 'test1.jstechno@gmail.com', 'password' => bcrypt('test1')],
            ['name' => 'Test User 2', 'email' => 'test2.jstechno@gmail.com', 'password' => bcrypt('test2')],
            ['name' => 'Test User 3', 'email' => 'test3.jstechno@gmail.com', 'password' => bcrypt('test3')],
            ['name' => 'Test User 4', 'email' => 'test4.jstechno@gmail.com', 'password' => bcrypt('test4')],
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
    }
}

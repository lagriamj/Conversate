<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                "name" => 'User 1',
                "username" => "user1",
                "email" => 'user1@gmail.com',
                "password" => bcrypt('password'),
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                "name" => 'User 2',
                "username" => "user2",
                "email" => "user2@gmail.com",
                "password" => bcrypt('password'),
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                "name" => 'User 3',
                "username" => "user3",
                "email" => "user3@gmail.com",
                "password" => bcrypt('password'),
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        //User::truncate();
        User::insert($fields);
    }
}
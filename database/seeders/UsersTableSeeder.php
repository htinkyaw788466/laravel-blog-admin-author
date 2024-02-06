<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id'=>'1',
            'name'=>'htin kyaw',
            'username'=>'admin',
            'email'=>'admin@faker.com',
            'password'=>bcrypt('12345678')
        ]);

        DB::table('users')->insert([
            'role_id'=>'2',
            'name'=>'chucky billy',
            'username'=>'author',
            'email'=>'author@faker.com',
            'password'=>bcrypt('12345678')
        ]);
    }
}

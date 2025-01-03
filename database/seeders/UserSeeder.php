<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert the admin user
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '+254705201161',
            'password' => Hash::make('12345678'),
            'role' => 'ADMIN',
        ]);

        // // Insert 19 random users
        // for ($i = 0; $i < 19; $i++) {
        //     DB::table('users')->insert([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'phone_number' => $faker->phoneNumber,
        //         'password' => Hash::make('password'), // or any default password
        //     ]);
        // }
    }
}

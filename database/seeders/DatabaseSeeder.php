<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use Database\Seeders\SpaceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        User::firstOrCreate(

            [
                'email' => 'admin@gmail.com',
            ],

            [
                'name' => 'Admin',

                'password' => bcrypt('Admin1234'),

                'role' => 'admin',
            ]

        );

        

        User::firstOrCreate(

            [
                'email' => 'juanita@gmail.com',
            ],

            [
                'name' => 'Juanita',

                'password' => bcrypt('Admin1234'),

                'role' => 'user',
            ]

        );

      

        $this->call([
            SpaceSeeder::class,
        ]);
    }
}
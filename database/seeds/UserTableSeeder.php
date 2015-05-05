<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    private $seed_number = 200;

    public function run()
    {
        // Set DB and clear
        $db = DB::table('users');
        $db->truncate();

        // Get Repo
        $users_repo = new \App\Repositories\User\UsersEloquent();

        // Faker
        $faker = Faker\Factory::create();

        // Run Seed
        for($i = 0; $i < $this->seed_number; $i++) {
            $users_repo->createRow([
                'email' => $faker->email,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'zip_code' => $faker->postcode,
                'confirmed' => $faker->numberBetween(0,1),
            ]);
        }

    }

}
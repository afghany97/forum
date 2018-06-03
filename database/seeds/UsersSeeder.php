<?php

use App\User;

class UsersSeeder extends MySeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        static $password;

        foreach(range(1,30) as $index)
        {
            User::create([
                'name' => $name =  $this->faker->name,
                'email' => $email = $this->faker->unique()->safeEmail,
                'password' => $password ?: $password = bcrypt('secret'),
                'remember_token' => str_random(10),
                'confirmation_token' => str_limit(md5($email.$name ),25,''),
                'confirmed' => false
            ]);
        }
    }
}

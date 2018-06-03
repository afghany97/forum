<?php

use Illuminate\Database\Seeder;

use Faker\Factory as faker;

class MySeeder extends Seeder
{
    protected  $faker;
    /**
     * MySeeder constructor.
     */
    public function __construct()
    {
        $this->faker = faker::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}

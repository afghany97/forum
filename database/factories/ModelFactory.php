<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

// define new factory to create new user

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

// define new factory to create new thread

$factory->define(App\Thread::class, function (Faker\Generator $faker) {

    return [
        'user_id' => function()
        {
        	return factory(App\User::class)->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});

// define new factory to create new reply

$factory->define(App\Reply::class, function (Faker\Generator $faker) {

    return [
        'user_id' => function()
        {
        	return factory(App\User::class)->create()->id;
        },
        'thread_id' => function()
        {
        	return factory(App\Thread::class)->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});

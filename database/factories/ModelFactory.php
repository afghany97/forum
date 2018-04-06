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
        'name' => $name =  $faker->name,
        'email' => $email = $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmation_token' => str_limit(md5($email.$name ),25,''),
        'confirmed' => false
    ];
});

// define new factory to create new thread

$factory->define(App\Thread::class, function (Faker\Generator $faker) {

    $title = $faker->sentence;
    return [
        'user_id' => function()
        {
        	return $threadId = factory(App\User::class)->create()->id;
        },
        'channel_id' => function()
        {
            return factory(App\Channel::class)->create()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'slug' => str_slug($title)
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

// define new factory to create new channel

$factory->define(App\Channel::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word
    ];
});

// define new factory for threads_vistoers table

$factory->define(App\ThreadsVistores::class, function (Faker\Generator $faker) {

    return [
        'thread_id' => factory('App\Thread')->create()->id,

        'vistoer_ip' => $faker->ipv4
    ];
});
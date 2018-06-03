<?php


use Faker\Factory as Faker;

use App\Thread;

class ThreadsSeeder extends MySeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1,30) as $index)
        {
            $title = $this->faker->sentence;

            Thread::create([
                'user_id' => rand(0,30),
                'channel_id' =>rand(0,30),
                'title' => $title,
                'body' => $this->faker->paragraph,
                'slug' => str_slug($title),
                'is_locked' => false

            ]);
        }
    }

}

<?php


use App\Channel;

class ChannelsSeeder extends MySeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,30) as $index)
        {
            Channel::create([
                'name' => $this->faker->word
            ]);
        }
    }
}

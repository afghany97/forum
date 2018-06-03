<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    private  $classes = [
        UsersSeeder::class,
        ChannelsSeeder::class,
        ThreadsSeeder::class
    ];

    private $models = [
        \App\User::class  ,
        \App\Channel::class  ,
        \App\Thread::class  ,
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->Truncate();

        foreach ($this->classes as $class)
        {
            $this->call($class);
        }

    }
//    private function Truncate()
//    {
//        foreach ($this->models as $model)
//        {
//            $model::truncate();
//        }
//
//    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    // use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;

    public function setup()
    {
        // call setUp function from parent class to be sure it's executed

        parent::setUp();

        // create a new thread

    	$this->thread = create(\App\Thread::class);
    }

    /**@test*/

    public function test_if_activity_records_when_user_create_new_thread()
    {
    	// create user and sing in

    	$this->signIn();

		// create new thread

    	$thread = create('App\Thread');

    	// fetch the last activity model 

    	$activity = \App\Activity::latest()->first();

    	// test if the thread id equals the subject_id in activity table

    	$this->assertEquals([$thread->id , 'App\Thread'] , [$activity->subject_id , $activity->subject_type]);
    }

}

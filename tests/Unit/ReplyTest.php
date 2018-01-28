<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{
	use DatabaseTransactions;


	public function test_if_user_can_see_replies()
	{
		$reply = factory(\App\Reply::class)->create();

		$this->get($reply->Thread->path())
		->assertSee($reply->body);
		
	}
   
}

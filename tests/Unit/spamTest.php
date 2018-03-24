<?php

namespace Tests\Unit;

use App\spam\spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class spamTest extends TestCase
{

	use DatabaseTransactions;

	/** @test */

	public function user_can_not_add_reply_contains_spam()
	{
		// make instance of spam class

		$spam = new spam;
		
		// this test expect exception

		$this->expectException('Exception');

		// class detect method to expect exception with spam param passed 

		$spam->detect('spam reply');
	}
	
	/** @test */

	public function valid_reply_will_pass_from_spam_detect()
	{
		// make instance of spam class
		
		$spam = new spam;

		// expcet false value from detect method with normal data

		$this->assertFalse($spam->detect('normal reply'));
	}

	/** @test */

	public function test_hold_down_spam()
	{
		// make instance of spam class
		
		$spam = new spam;

		// this test expect exception

		$this->expectException('Exception');

		// class detect method to expect exception with spam param passed 
		
		$spam->detect('555555');
	}
}

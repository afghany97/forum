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
		$spam = new spam;

		$this->expectException('Exception');

		$spam->detect('spam reply');
	}
	
	/** @test */

	public function valid_reply_will_pass_from_spam_detect()
	{
		$spam = new spam;

		$this->assertFalse($spam->detect('normal reply'));
	}

	/** @test */

	public function test_hold_down_spam()
	{
		$spam = new spam;

		$this->expectException('Exception');

		$spam->detect('555555');
	}
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddAvatarTest extends TestCase
{
	use DatabaseTransactions;

    /** @test */

	public function unauthenticated_users_can_not_add_avatar()
    {
        // this test expect AuthenticationException

    	$this->expectException('Illuminate\Auth\AuthenticationException');

    	// send post request for upload avatar endpoint

    	$this->post('users/username/avatar')

            // check if redirected to login page

    		->assertRedirect('/login');
    }

    /** @test */

    public function user_may_add_avatar()
    {
        // create user and sigin in

        $this->signIn();

        // work with fake storage

        Storage::fake('public');

        // send post request to upload avatar endpoint with fake image

        $this->post('users/username/avatar' , [

            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        // check if the fake image uploaded to fake storage
        
        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }

}

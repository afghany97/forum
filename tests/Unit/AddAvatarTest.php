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
    	$this->expectException('Illuminate\Auth\AuthenticationException');

    	$this->post('users/username/avatar')
    		
    		->assertRedirect('/login');
    }

    /** @test */

    public function user_may_add_avatar()
    {
        $this->signIn();

        Storage::fake('public');

        $this->post('users/username/avatar' , [

            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }

}

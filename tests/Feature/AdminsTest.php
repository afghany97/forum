<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function admin_can_access_control_page()
    {
        $this->signIn($admin = create('App\User',['is_admin' => true]))->confirm($admin);

        $this->get('/admin/control')

            ->assertStatus(200);
    }

    /** @test */

    public function non_admin_can_not_access_control_page()
    {
        $this->signIn($user= create('App\User'))->confirm($user);

        $this->get('/admin/control')

            ->assertStatus(401)

            ->assertSee('action not allowed');
    }
}

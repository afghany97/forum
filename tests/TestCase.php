<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
    	$user = $user ?: create(\App\User::class);

    	$this->be($user);

    	return $this;
    }

    protected function confirm($user = null)
    {
        $user = $user ?: create(\App\User::class);

        $this->get('/register/confirm/'.$user->confirmation_token);

        return $this;
    }
}

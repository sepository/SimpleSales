<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function authorize($isAdmin = 0)
    {
        $user = factory(User::class)->create([
            'is_admin' => $isAdmin,
        ]);

        $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
    }
}

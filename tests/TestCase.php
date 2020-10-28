<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $authEmail = 'test@example.co.jp';

    protected function authorize($isAdmin = 0)
    {
        factory(User::class)->create([
            'email' => $this->authEmail,
        ]);

        $this->post('/api/login', [
            'email' => $this->authEmail,
            'password' => 'password',
            'is_admin' => $isAdmin,
        ]);
    }
}

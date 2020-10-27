<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function testSetLocale()
    {
        $response = $this->json('POST', '/api/locale/ja');
        $response
            ->assertOk()
            ->assertExactJson([
                'result' => 'OK',
            ]);
    }
}

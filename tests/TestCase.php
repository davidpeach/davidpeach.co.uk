<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function w($exceptions = [])
    {
        $this->withoutExceptionHandling($exceptions);
    }

    public function login()
    {
        $user = User::factory()->create();
        $this->be($user);
    }
}

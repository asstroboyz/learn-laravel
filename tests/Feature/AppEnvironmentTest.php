<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAppEnvironment()
    {
        var_dump(App::environment());
    }
}

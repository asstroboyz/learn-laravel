<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserServices $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserServices::class);
    }

    public function testSample(){
        self::assertTrue(true);
    }
    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login('admin', 'admin123'));
    }
    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login('anto', 'admin'));
    }
    public function testLoginUserPasswordIncorrect()
    {
        self::assertFalse($this->userService->login('admin', 'wrongpassword'));
    }
}

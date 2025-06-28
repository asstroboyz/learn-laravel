<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
  
    public function testLogin()
    {
      $this->get('/login')
           ->assertSeeText('Login');
    }

    public function testLoginSuccess()
    {
        $response = $this->post('/login', [
            'user' => 'admin',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/')
                 ->assertSessionHas('success', 'Login successful!');
    }
    
    public function testLoginValidation()
    {
        $response = $this->post('/login', []);

        $response->assertViewIs('user.login')
                 ->assertSeeText('User and password are required.');
    }
    public function testLoginFailed()
    {
        $response = $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrongpassword',
        ]);

        $response->assertSeeText('Invalid user or password.');
    }
    public function testLogout()
    {
       
        $this->withSession(['user' => 'admin'])
             ->post('/logout')
             ->assertRedirect('/')
             ->assertSessionHas('success', 'Logout successful!');
    }
  
    public function testLoginForMember()
    {
        $this->withSession(['user' => 'admin'])
             ->get('/login')
             ->assertSeeText('/');
   }

    public function testLoginForSuccess()
    {
       $this->post('/login', [
            'user' => 'admin',
            'password' => 'guestpassword',
        ])->assertRedirect('/')
             ->assertSessionHas('success', 'admin successful!');
    }
    public function testLoginAlreadyLogin()
{
    $this->withSession([
        'user' => 'admin',
    ])->post('/login', [ 
        'user' => 'admin',
        'password' => 'admin123',
    ])->assertRedirect('/');
}

 }

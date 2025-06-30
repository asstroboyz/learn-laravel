<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserServices $userService;
    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }
    public function login(): Response
    {
        return response()->view('user.login', [
            'title' => 'Login',

        ]);
    }
    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input('user');
        $password = $request->input('password');

        // Validate input
        if (empty($user) || empty($password)) {
            return response()->view('user.login', [
                'title' => 'Login',
                'error' => 'User and password are required.',
            ]);
        }

        if ($this->userService->login($user, $password)) {
            $request->session()->put('user', $user);
            return redirect('/')->with('success', 'Login successful!');
        } else {
            return response()->view('user.login', [
                'title' => 'Login',
                'error' => 'Invalid user or password.',
            ]);
        }
    }

    public function doLogout(Request $request): RedirectResponse
    {
        if ($request->session()->has('user')) {
            $request->session()->forget('user');
            return redirect('/')->with('success', 'Logout successful!');
        }

 
        return redirect('/');
    }
}

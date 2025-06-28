<?php

namespace App\Services;

interface UserServices
{
    function login(string $user, string $password): bool;
}
<?php

namespace App\Auth;

use App\Core\IAuthenticator;

class Authenticator implements IAuthenticator
{

    public function __construct()
    {
        session_start();
    }

    function login($userLogin, $pass): bool
    {
        // TODO: Implement login() method.
    }

    function logout(): void
    {
        // TODO: Implement logout() method.
    }

    function getLoggedUserName(): string
    {
        // TODO: Implement getLoggedUserName() method.
    }

    function getLoggedUserId(): mixed
    {
        // TODO: Implement getLoggedUserId() method.
    }

    function getLoggedUserContext(): mixed
    {
        // TODO: Implement getLoggedUserContext() method.
    }

    function isLogged(): bool
    {
        // TODO: Implement isLogged() method.
    }
}
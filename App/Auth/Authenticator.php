<?php

namespace App\Auth;

use App\Core\IAuthenticator;
use App\Models\User;

class Authenticator implements IAuthenticator
{

    public function __construct()
    {
        session_start();
    }

    function login($userLogin, $pass): bool
    {
        $user = User::getAll("email = ?", [$userLogin]);
        if (count($user) == 0) {
            return false;
        }
        if ($userLogin == $user[0]->getEmail() && password_verify($pass, $user[0]->getPasswordHash())) {
            $_SESSION['user'] = $user[0]->getName();
            return true;
        } else {
            return false;
        }
    }

    function logout(): void
    {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            session_destroy();
        }
    }

    function getLoggedUserName(): string
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : throw new \Exception("User not logged in");
    }

    function getLoggedUserId(): mixed
    {
        return $_SESSION['user'];
    }

    function getLoggedUserContext(): mixed
    {
        return null;
    }

    function isLogged(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user'] != null;
    }
}
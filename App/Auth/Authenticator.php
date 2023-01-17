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
        if (strcmp($userLogin, $user[0]->getEmail()) == 0 && password_verify($pass, $user[0]->getPasswordHash())) {
            $_SESSION['user_name'] = $user[0]->getName();
            $_SESSION['user_id'] = $user[0]->getId();
            return true;
        } else {
            return false;
        }
    }

    function logout(): void
    {
        if (isset($_SESSION["user_name"]) || isset($_SESSION['user_id'])) {
            unset($_SESSION["user_name"]);
            unset($_SESSION["user_id"]);
            session_destroy();
        }
    }

    function getLoggedUserName(): string
    {
        return $_SESSION['user_name'] ?? throw new \Exception("User not logged in");
    }

    function getLoggedUserId(): mixed
    {
        return $_SESSION['user_id'] ?? throw new \Exception("User not logged in");
    }

    function getLoggedUserContext(): mixed
    {
        return null;
    }

    function isLogged(): bool
    {
        return isset($_SESSION['user_name']) && $_SESSION['user_name'] != null;
    }
}
<?php

namespace App\Helpers;

class Validator
{

    static function validateUsername($username): bool {
        if($username && preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,23}[0-9a-zA-Z]$/',$username)) {
            return true;
        }
        return false;
    }

    static function validatePassword($password): bool {
        if($password && preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d$@$!%*#?&]{8,}$/',$password)) {
            return true;
        }
        return false;
    }

    static function validateTelephone($telephone): bool {
        if($telephone && preg_match('/^(\+|[0-9])[0-9]{6,15}$/',$telephone)) {
            return true;
        }
        return false;
    }

    static function validatePrice($price): bool {
        if ($price && preg_match('/^\d+((\.|\,)\d+)?$/', $price)) {
            return true;
        }
        return false;
    }


}
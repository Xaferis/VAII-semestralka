<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Helpers\Validator;
use App\Models\User;

/**
 * Class AuthController
 * Controller for authentication actions
 * @package App\Controllers
 */
class AuthController extends AControllerBase
{
    /**
     * Shows the login page
     * @return \App\Core\Responses\RedirectResponse|\App\Core\Responses\Response
     */
    public function index(): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Login a user
     * @return \App\Core\Responses\RedirectResponse|\App\Core\Responses\ViewResponse
     */
    public function login(): Response
    {
        if ($this->app->getAuth()->isLogged()) {
            return $this->redirect('?c=home');
        }
        $formData = $this->app->getRequest()->getPost();
        $isLogged = null;
        if (isset($formData['submit'])) {
            $isLogged = $this->app->getAuth()->login($formData['login'], $formData['password']);
            if ($isLogged) {
                return $this->redirect('?c=home');
            }
        }

        $data = ($isLogged === false ? ['message' => 'Zlý login alebo heslo!', 'isMessageError' => true] : []);
        return $this->html($data);
    }

    /**
     * Register a user
     * @return \App\Core\Responses\RedirectResponse|\App\Core\Responses\ViewResponse
     */
    public function register(): Response
    {
        if ($this->app->getAuth()->isLogged()) {
            return $this->redirect('?c=home');
        }
        $formData = $this->app->getRequest()->getPost();
        if (isset($formData['submit'])) {
            if (!$formData['login'] || !$formData['name'] || !$formData['password'] || !$formData['password_check']) {
                return $this->html(['message' => 'Musia byť vyplnené všetky polia!', 'isMessageError' => true]);
            }
            if (!filter_var($formData['login'], FILTER_VALIDATE_EMAIL)) {
                return $this->html(['message' => 'Nesprávny formát e-mailu!', 'isMessageError' => true]);
            }
            $isEmailTaken = User::getAll('email = ?', [$formData['login']]);
            if (count($isEmailTaken) != 0) {
                return $this->html(['message' => 'Účet s daným e-mailom už existuje!', 'isMessageError' => true]);
            }
            if (!Validator::validatePassword($formData['password'])) {
                return $this->html(['message' => 'Heslo musí mať min. 8 znakov, aspoň 1 písmeno a aspoň 1 číslicu!', 'isMessageError' => true]);
            }
            if (strcmp($formData['password'],$formData['password_check']) != 0) {
                return $this->html(['message' => 'Heslá sa nezhodujú!', 'isMessageError' => true]);
            }
            if (!Validator::validateUsername($formData['name'])) {
                return $this->html(['message' => 'Prezývka musí byť dlhá 4-25 znakov, musí začínať písmenom, povolené sú znaky "a-Z,1-9,_"!', 'isMessageError' => true]);
            }

            $user = new User();
            $user->setEmail($formData['login']);
            $user->setPasswordHash(password_hash($formData['password'], PASSWORD_DEFAULT));
            $user->setName($formData['name']);
            $user->save();
            return $this->html([
                'message' => 'Registrácia prebehla úspešne! Môžete sa teraz prihlásiť',
                'isMessageError' => false
            ], 'login');
        }
        return $this->html([]);
    }

    /**
     * Logout a user
     * @return \App\Core\Responses\ViewResponse
     */
    public function logout(): Response
    {
        $this->app->getAuth()->logout();
        return $this->redirect('?c=home');
    }

}
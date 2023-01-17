<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;

/**
 * Class AuthController
 * Controller for authentication actions
 * @package App\Controllers
 */
class AuthController extends AControllerBase
{
    /**
     *
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
        $logged = null;
        if (isset($formData['submit'])) {
            $logged = $this->app->getAuth()->login($formData['login'], $formData['password']);
            if ($logged) {
                return $this->redirect('?c=home');
            }
        }

        $data = ($logged === false ? ['message' => 'Zlý login alebo heslo!'] : []);
        return $this->html($data);
    }

    public function register(): Response
    {
        if ($this->app->getAuth()->isLogged()) {
            return $this->redirect('?c=home');
        }
        $formData = $this->app->getRequest()->getPost();
        if (isset($formData['submit'])) {
            if (!$formData['login'] || !$formData['name'] || !$formData['password'] || !$formData['password_check']) {
                return $this->html(['message' => 'Jedno alebo viac polia nie su vyplnene!']);
            }
            if (!filter_var($formData['login'], FILTER_VALIDATE_EMAIL)) {
                return $this->html(['message' => 'Nespravny format e-mailu!']);
            }
            $isEmailTaken = User::getAll('email = ?', [$formData['login']]);
            if (count($isEmailTaken) != 0) {
                return $this->html(['message' => 'Ucet s danym e-mailom uz existuje!']);
            }
            if (strcmp($formData['password'],$formData['password_check']) != 0) {
                return $this->html(['message' => 'Hesla sa nezhoduju!']);
            }
            if (strlen('password') < 7) {
                return $this->html(['message' => 'Heslo musi mat aspon 7 znakov!']);
            }
            if (strlen($formData['name']) < 3) {
                return $this->html(['message' => 'Meno musi mat aspon 3 znaky!']);
            }

            $user = new User();
            $user->setEmail($formData['login']);
            $user->setPasswordHash(password_hash($formData['password'], PASSWORD_DEFAULT));
            $user->setName($formData['name']);
            $user->save();
            return $this->redirect('?c=auth&a=login');
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
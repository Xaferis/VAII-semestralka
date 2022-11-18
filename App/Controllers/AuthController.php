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
        $data = [];
        if (isset($formData['submit'])) {
            $isEmailTaken = User::getAll('email = ?', [$formData['login']]);
            if (count($isEmailTaken) == 0) {
                if (($formData['password'] === $formData['password_check'])) {
                    $user = new User();
                    $user->setEmail($formData['login']);
                    $user->setPasswordHash(password_hash($formData['password'], PASSWORD_DEFAULT));
                    $user->setName($formData['name']);
                    $user->save();
                    return $this->redirect('?c=auth&a=login');
                } else {
                    $data = ['message' => 'Hesla sa nezhoduju!'];
                }
            } else {
                $data = ['message' => 'Ucet s danym e-mailom uz existuje!'];
            }
        }
        return $this->html($data);
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
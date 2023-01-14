<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Helpers\Validator;
use App\Models\User;
use App\Core\Responses\Response;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class ProfileController extends AControllerBase
{
    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        return $this->app->getAuth()->isLogged();
    }

    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        $user = User::getOne($this->app->getAuth()->getLoggedUserId());
        return $this->html(['user' => $user]);
    }

    public function update(): Response {
        $user = User::getOne($this->app->getAuth()->getLoggedUserId());

        $username = $this->request()->getValue('username');
        if (!Validator::validateUsername($username)) {
            return $this->json([
                'user' => $user,
                'isSuccessful' => false,
                'cause' => "username",
                'message' => 'Zlý formát prezývky, prezývka musí byť dlhá 4-25 znakov, musí začínať písmenom, povolené "a-Z,1-9,_"!'
            ]);
        }

        $telephone = $this->request()->getValue('telephone');
        if (strlen($telephone) > 0 && !Validator::validateTelephone($telephone)) {
            return $this->json([
                'user' => $user,
                'isSuccessful' => false,
                'cause' => "telephone",
                'message' => "Zlý formát telefónneho čísla, v čísle môžu byť len číslice alebo + (na začiatku), veľkosť 7-12 číslic!"
            ]);
        }

        $image = $this->request()->getValue('file_path');

        $user->setName($username);
        $user->setTelephone($telephone);
        $user->setImagePath($image);
        $user->save();

        return $this->json([
            'user' => $user,
            'isSuccessful' => true,
            'message' => "Údaje úspešne aktualizované!"
        ]);
    }

    public function uploadImage(): Response
    {
        $file = $this->request()->getFiles()['photo'];

        if (!$file) {
            return $this->json(['isSuccessful' => false]);
        }

        $file_name = $file['name'];
        $file_tmp_name = $file['tmp_name'];
        $file_error = $file['error'];

        if ($file_error != UPLOAD_ERR_OK) {
            return $this->json(['isSuccessful' => false]);
        }

        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_new_name = uniqid('IMG-', true).'.'.strtolower($file_ext);
        $file_upload_path = 'public/images/profile/'.$file_new_name;

        move_uploaded_file($file_tmp_name, $file_upload_path);

        return $this->json([
            'isSuccessful' => true,
            'file_path' => $file_upload_path
        ]);
    }

    public function deleteImage(): Response {
        $imageName = $this->request()->getValue('imageName');

        if ($imageName) {
            unlink($imageName);
            return $this->json(['isSuccessful' => true]);
        }

        return $this->json(['isSuccessful' => false]);
    }

    public function changePassword(): Response {
        $user = User::getOne($this->app->getAuth()->getLoggedUserId());
        $oldPassword = $this->request()->getValue('old_password');
        if (!$oldPassword || !password_verify($oldPassword, $user->getPasswordHash())) {
            return $this->html([
                'isMessageError' => true,
                'message' => "Nesprávne heslo!",
                'user' => $user
            ], 'index');
        }

        $newPassword = $this->request()->getValue('new_password');
        $newPasswordRepeat = $this->request()->getValue('new_password_repeat');

        if (!$newPassword || !$newPasswordRepeat || strcmp($newPassword, $newPasswordRepeat) != 0) {
            return $this->html([
                'isMessageError' => true,
                'message' => "Nové heslá sa nezhodujú!",
                'user' => $user
            ], 'index');
        }

        if (!Validator::validatePassword($newPassword)) {
            return $this->html([
                'isMessageError' => true,
                'message' => "Nové heslo nemá správny tvar alebo dĺžku. Heslo musí mať min. 8 znakov, aspoň 1 písmeno a aspoň 1 číslicu.",
                'user' => $user
            ], 'index');
        }

        $user->setPasswordHash(password_hash($newPassword,PASSWORD_DEFAULT));
        $user->save();

        return $this->html([
            'isMessageError' => false,
            'message' => "Heslo úspešne zmenené!",
            'user' => $user
        ], 'index');
    }
}
<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Favorite_post;

class FavoritePostsController extends AControllerBase
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

    public function index(): Response
    {
        $favoritePosts = Favorite_post::getAll("user_id = ?", [$this->app->getAuth()->getLoggedUserId()]);
        return $this->html($favoritePosts);
    }

    public function delete()
    {
        $post = Favorite_post::getOne($this->request()->getValue('id'));

        if ($post && $post->getUserId() === $this->app->getAuth()->getLoggedUserId()) {
            $post->delete();
        }

        return $this->redirect("?c=favoritePosts");
    }
}
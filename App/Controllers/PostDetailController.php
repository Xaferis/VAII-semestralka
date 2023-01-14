<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Favorite_post;
use App\Models\Post;
use App\Models\User;

class PostDetailController extends AControllerBase
{

    public function index(): Response
    {
        $post = Post::getOne($this->request()->getValue('id'));
        $favoritePost = false;
        if (isset(Favorite_post::getAll("post_id = ?", [$post->getId()])[0])) {
            $favoritePost = true;
        }
        $user = User::getOne($post->getUserId());
        return $this->html([
            'post' => $post,
            'isFavorite' => $favoritePost,
            'user' => $user
        ]);
    }

    public function updateFavoriteState(): Response {
        $post_id = $this->request()->getValue('post_id');
        $favoritePosts = Favorite_post::getAll("post_id = ?", [$post_id]);
        $favoritePost = $favoritePosts[0] ?? null;

        if (!$this->app->getAuth()->isLogged()) {
            return $this->json(['isSuccessful' => false]);
        }

        if ($favoritePost) {
            if ($favoritePost->getUserId() === $this->app->getAuth()->getLoggedUserId()) {
                $favoritePost->delete();
                $didDelete = true;
            } else {
                return $this->json(['isSuccessful' => false]);
            }
        } else {
            $favoritePost = new Favorite_post();
            $favoritePost->setPostId($post_id);
            $favoritePost->setUserId($this->app->getAuth()->getLoggedUserId());
            $favoritePost->save();
            $didDelete = false;
        }

        return $this->json(['isSuccessful' => true, 'didDelete' => $didDelete]);
    }
}
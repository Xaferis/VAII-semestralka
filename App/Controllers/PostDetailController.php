<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Favorite_post;
use App\Models\Post;
use App\Models\User;

class PostDetailController extends AControllerBase
{

    /**
     * Shows a page with post detail
     * URL params, which are used here:
     *  - id -> id of a post
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        $postId = $this->request()->getValue('id');
        $posts = array_map(function ($array_item) { return $array_item->getId(); }, Post::getAll());
        if (!$postId || !is_numeric($postId) || !in_array($postId, $posts)) {
            return $this->redirect("?c=home");
        }

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

    /**
     * This function adds or removes post from user's favorites
     * Request params, which are used here:
     *  - post_id -> post id which we want to add or remove
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
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
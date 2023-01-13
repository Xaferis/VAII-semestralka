<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Post;

class PostDetailController extends AControllerBase
{

    public function index(): Response
    {
        $post = Post::getOne($this->request()->getValue('id'));
        return $this->html($post);
    }
}
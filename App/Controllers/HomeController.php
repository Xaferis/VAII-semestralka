<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Post;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{
    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        return true;
    }

    /**
     * Shows homepage
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        $categories = Category::getAll("", [], "",4);
        $posts = Post::getAll("", [], "",4);
        return $this->html([
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * Shows contact page
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function contact(): Response
    {
        return $this->html();
    }

    /**
     * Shows FAQ page
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function faq(): Response {
        return $this->html();
    }

    /**
     * Shows refund policy page
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function refundPolicy(): Response {
        return $this->html();
    }
}
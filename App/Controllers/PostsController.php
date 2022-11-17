<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Post;

class PostsController extends AControllerBase
{

    public function authorize($action)
    {
        return $this->app->getAuth()->isLogged();
    }

    public function index(): Response
    {
        $posts = Post::getAll("user_id = ?", [$this->app->getAuth()->getLoggedUserId()]);
        return $this->html($posts);
    }

    public function create(): Response
    {
        return $this->html(['post' => new Post(), 'categories' => Category::getAll()]);
    }

    public function store() {
        $id = $this->request()->getValue('id');
        $post = ($id ? Post::getOne($id) : new Post());

        //overenie
        $post->setTitle($this->request()->getValue('title'));
        $post->setDescription($this->request()->getValue('description'));
        $post->setCategoryId($this->request()->getValue('category'));
        $post->setPrice($this->request()->getValue('price'));
        $post->setUserId($this->app->getAuth()->getLoggedUserId());
        $post->save();

        return $this->redirect("?c=posts");

    }

    public function edit()
    {
        $post = Post::getOne($this->request()->getValue('id'));
        $categories = Category::getAll("id <> ?", [$post->getCategoryId()]);
        array_unshift($categories, Category::getOne($post->getCategoryId()));

        return $this->html(['post' => $post, 'categories' => $categories], 'create');
    }

    public function delete()
    {
        $post = Post::getOne($this->request()->getValue('id'));
        $post->delete();

        return $this->redirect("?c=posts");
    }

}
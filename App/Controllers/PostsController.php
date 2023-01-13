<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Post;
use App\Models\Post_image;

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
        return $this->html([
            'post' => new Post(),
            'categories' => Category::getAll(),
            'title' => 'Pridanie inzerátu',
            'button' => 'Vytvoriť inzerát'
        ]);
    }

    public function store()
    {
        $id = $this->request()->getValue('id');
        $post = ($id ? Post::getOne($id) : new Post());

        $title = $this->request()->getValue('title');
        $description = $this->request()->getValue('description');
        $categoryID = $this->request()->getValue('category');
        $subcategoryID = $this->request()->getValue('subcategory');
        $price = str_replace(",", ".", $this->request()->getValue('price'));

        if (!$title || !$description || !$categoryID || !$subcategoryID || !$price) {
            return $id
                ? $this->redirect("?c=posts&a=edit&id=".$id)
                : $this->redirect("?c=posts&a=create");
        }
        if (!is_numeric($price)) {
            return $id
                ? $this->redirect("?c=posts&a=edit&id=".$id)
                : $this->redirect("?c=posts&a=create");
        }

        $post->setTitle($title);
        $post->setDescription($description);
        $post->setCategoryId($categoryID);
        $post->setSubcategoryId($subcategoryID);
        $post->setPrice($price);

        $post->setUserId($this->app->getAuth()->getLoggedUserId());
        $post->save();

//        $this->processFiles($post->getId());

        return $this->redirect("?c=posts");
    }

    public function edit()
    {
        $post = Post::getOne($this->request()->getValue('id'));
        if (!$post || $post->getUserId() != $this->app->getAuth()->getLoggedUserId()) {
            return $this->redirect("?c=posts&a=create");
        }
        $categories = Category::getAll("id <> ?", [$post->getCategoryId()]);
        array_unshift($categories, Category::getOne($post->getCategoryId()));

        return $this->html([
            'post' => $post,
            'categories' => $categories,
            'title' => 'Úprava inzerátu',
            'button' => 'Uložiť zmeny'
        ],
            'create');
    }

    public function delete()
    {
        $post = Post::getOne($this->request()->getValue('id'));

        if ($post) {
            $post->delete();
        }

        return $this->redirect("?c=posts");
    }

    public function updateSubcategories(): Response
    {
        $id = $this->request()->getValue('selectedValue');

        return $this->json(['subcategories' => Category::getOne($id)->getSubcategories()]);
    }

    public function processImages(): Response
    {
        $isSuccessful = true;
        $images_names = [];
        $files = $this->request()->getFiles()['photo'];

        for ($i = 0; $i < count($files['name']); $i++) {
            $file_name = $files['name'][$i];
            $file_tmp_name = $files['tmp_name'][$i];
            $file_error = $files['error'][$i];

            if ($file_error != UPLOAD_ERR_OK) {
                $isSuccessful = false;
                break;
            }

            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_new_name = uniqid('IMG-', true).'.'.strtolower($file_ext);
            $file_upload_path = 'public/images/uploads/'.$file_new_name;

            move_uploaded_file($file_tmp_name, $file_upload_path);
            $images_names[] = $file_new_name;
        }

        return $this->json([
            'isSuccessful' => $isSuccessful,
            'file_names' => $images_names
        ]);
    }

}
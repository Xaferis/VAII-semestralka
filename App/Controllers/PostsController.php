<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Helpers\Validator;
use App\Models\Category;
use App\Models\Post;
use App\Models\Post_image;

class PostsController extends AControllerBase
{
    /**
     * Checks if user is logged in
     */
    public function authorize($action)
    {
        return $this->app->getAuth()->isLogged();
    }

    /**
     * Shows user's posts
     * @return \App\Core\Responses\RedirectResponse|\App\Core\Responses\Response
     * @throws \Exception
     */
    public function index(): Response
    {
        $posts = Post::getAll("user_id = ?", [$this->app->getAuth()->getLoggedUserId()]);
        return $this->html($posts);
    }

    /**
     * This function shows a view with a form for creating new posts
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function create(): Response
    {
        return $this->html([
            'post' => new Post(),
            'categories' => Category::getAll(),
            'title' => 'Pridanie inzerátu',
            'button' => 'Vytvoriť inzerát'
        ]);
    }

    /**
     * This function shows a view with a filled form of a post, we want to edit
     * Request params, which are used here:
     *  - id -> post id which we want to edit
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function edit()
    {
        $post = Post::getOne($this->request()->getValue('id'));
        if (!$post || $post->getUserId() != $this->app->getAuth()->getLoggedUserId()) {
            return $this->redirect("?c=posts&a=create");
        }
        $categories = Category::getAll("id <> ?", [$post->getCategoryId()]);
        array_unshift($categories, Category::getOne($post->getCategoryId()));

        $images = Post_image::getAll('post_id = ?', [$post->getId()]);

        return $this->html([
            'post' => $post,
            'categories' => $categories,
            'images' => $images,
            'title' => 'Úprava inzerátu',
            'button' => 'Uložiť zmeny'
        ], 'create');
    }

    /**
     * This function deletes post from a database, it redirects a user to posts view afterwards
     * Request params, which are used here:
     *  - id -> post id which delete
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function delete()
    {
        $post = Post::getOne($this->request()->getValue('id'));
        $post?->safeDelete();

        return $this->redirect("?c=posts");
    }

    /**
     * This function stores posts to database, it redirects a user to posts view afterwards
     * Request params, which are used here:
     *  - id -> post id which we want to edit, if is null, it will add it instead
     *  - title -> post title
     *  - description -> post description
     *  - category -> post category
     *  - subcategory -> post subcategory
     *  - images_paths -> array of images
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function store()
    {
        $id = $this->request()->getValue('id');
        $post = ($id ? Post::getOne($id) : new Post());

        $title = $this->request()->getValue('title');
        $description = $this->request()->getValue('description');
        $categoryID = $this->request()->getValue('category');
        $subcategoryID = $this->request()->getValue('subcategory');
        $price = str_replace(",", ".", $this->request()->getValue('price'));
        $images = $this->request()->getValue('images_paths');

        if (!$title || !$description || !$categoryID || !$subcategoryID || !$price) {
            return $id
                ? $this->redirect("?c=posts&a=edit&id=".$id)
                : $this->redirect("?c=posts&a=create");
        }
        if (!Validator::validatePrice($price) || $price <= 0) {
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

        if ($id) {
            $shouldEnd = $this->mergeImages($images, $post);
            if ($shouldEnd) {
                return $this->redirect("?c=posts");
            }
        } else {
            $this->saveImages($images, $post->getId());
        }

        return $this->redirect("?c=posts");
    }

    private function mergeImages($images, $post): bool {
        /** @var Post $post */
        $currentImages = Post_image::getAll('post_id = ?', [$post->getId()]);

        if (!$images || count($images) == 0) {
            foreach ($currentImages as $currentImage) {
                $currentImage->completeDelete();
            }
            return true;
        }

        if (!$currentImages || count($currentImages) == 0) {
            $this->saveImages($images, $post->getId());

            return true;
        }

        foreach ($currentImages as $currentImage) {
            if (!in_array($currentImage->getImagePath(), $images)) {
                $currentImage->completeDelete();
            }
        }

        $currentImagesNames = array_map(function ($array_item) { return $array_item->getImagePath(); }, $currentImages);
        foreach ($images as $image) {
            if (!in_array($image, $currentImagesNames)) {
                $this->saveImages(array($image), $post->getId());
            }
        }

        return false;
    }

    private function saveImages($images, $id) {
        if ($images && count($images) > 0) {
            foreach ($images as $image) {
                $post_image = new Post_image();
                $post_image->setImagePath($image);
                $post_image->setPostId($id);
                $post_image->save();
            }
        }
    }

    /**
     * This function will upload images to the server, uses "photo" request param
     * @return \App\Core\Responses\Response|\App\Core\Responses\JsonResponse
     */
    public function uploadImages(): Response
    {
        $images_paths = [];
        $files = $this->request()->getFiles()['photo'];

        if (!$files) {
            return $this->json(['isSuccessful' => false]);
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            $file_name = $files['name'][$i];
            $file_tmp_name = $files['tmp_name'][$i];
            $file_error = $files['error'][$i];

            if ($file_error != UPLOAD_ERR_OK) {
                return $this->json(['isSuccessful' => false]);
            }

            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_new_name = uniqid('IMG-', true).'.'.strtolower($file_ext);
            $file_upload_path = 'public/images/uploads/'.$file_new_name;

            move_uploaded_file($file_tmp_name, $file_upload_path);
            $images_paths[] = $file_upload_path;
        }

        return $this->json([
            'isSuccessful' => true,
            'file_names' => $images_paths
        ]);
    }

    /**
     * This function will delete Image from server
     * @return \App\Core\Responses\Response|\App\Core\Responses\JsonResponse
     */
    public function deleteImage(): Response {
        $imageName = $this->request()->getValue('imagePath');

        if ($imageName) {
            unlink($imageName);
            return $this->json(['isSuccessful' => true]);
        }

        return $this->json(['isSuccessful' => false]);
    }

    /**
     * This function will update subcategories according to selected category
     * @return \App\Core\Responses\Response|\App\Core\Responses\JsonResponse
     */
    public function updateSubcategories(): Response
    {
        $id = $this->request()->getValue('selectedValue');

        return $this->json(['subcategories' => Category::getOne($id)->getSubcategories()]);
    }

}
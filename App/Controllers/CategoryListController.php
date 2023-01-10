<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;

class CategoryListController extends AControllerBase
{

    public function index(): Response
    {
        $categories = Category::getAll();
        return $this->html($categories);
    }

}
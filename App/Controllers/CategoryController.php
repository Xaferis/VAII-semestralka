<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends AControllerBase
{

    public function index(): Response
    {
        $category = Category::getOne($this->request()->getValue('id'));
        return $this->html($category);
    }

}
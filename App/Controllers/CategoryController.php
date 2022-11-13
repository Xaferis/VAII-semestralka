<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;

class CategoryController extends AControllerBase
{
    public function index(): Response
    {
        $categories = Category::getAll('id');
        return $this->index($categories);
    }

}
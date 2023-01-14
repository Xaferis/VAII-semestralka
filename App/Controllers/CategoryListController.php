<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Post;

class CategoryListController extends AControllerBase
{

    public function index(): Response
    {
        $categories = Category::getAll();
        return $this->html($categories);
    }

    public function show(): Response {
        $category = Category::getOne($this->request()->getValue('category'));
        $subcategory = $this->request()->getValue('subcategory');
        $orderBy = $this->request()->getValue('orderBy');
        $data['category'] = $category;
        $data['categoryParam'] = "&category=" . $category->getId();

        $whereClause = "category_id = ?";
        $whereParams[] = $category->getId();
        $orderByClause = '';

        if ($subcategory) {
            $whereClause .= " AND subcategory_id = ?";
            $whereParams[] = $subcategory;
            $data['subcategoryParam'] = "&subcategory=" . $subcategory;
        }

        if($orderBy) {
            $orderByClause .= 'price '.$orderBy;
            $data['orderByParam'] = "&orderBy=" . $orderBy;
        }

        $posts= Post::getAll($whereClause, $whereParams, $orderByClause);
        $data['posts'] = $posts;

        return $this->html($data);
    }

}
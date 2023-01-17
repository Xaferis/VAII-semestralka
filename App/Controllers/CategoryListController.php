<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Post;

class CategoryListController extends AControllerBase
{

    /**
     * Shows a page with category list
     * @return \App\Core\Responses\RedirectResponse|\App\Core\Responses\Response
     */
    public function index(): Response
    {
        $categories = Category::getAll();
        return $this->html($categories);
    }

    /**
     * This function will show posts from url parameters.
     * Request params, which are used here:
     *  - category (number) -> id of category (required)
     *  - subcategory (number) -> id of subcategory (optional)
     *  - orderBy (ASC/DESC) -> in which order should be result sorted (according to post price)
     * @return \App\Core\Responses\RedirectResponse|\App\Core\Responses\ViewResponse
     */
    public function show(): Response {
        $categoryId = $this->request()->getValue('category');

        if (!$categoryId || !is_numeric($categoryId) || $categoryId < 1 || $categoryId > count(Category::getAll())) {
            return $this->redirect("?c=categoryList");
        }

        $category = Category::getOne($categoryId);
        $subcategory = $this->request()->getValue('subcategory');
        $orderBy = $this->request()->getValue('orderBy');
        $data['category'] = $category;
        $data['categoryParam'] = "&category=" . $category->getId();

        $whereClause = "category_id = ?";
        $whereParams[] = $category->getId();
        $orderByClause = '';

        if ($subcategory) {
            $subcategories = array_map(function ($array_item) { return $array_item->getId(); }, $category->getSubcategories());
            if (is_numeric($subcategory) && $subcategory >= 1 && in_array($subcategory, $subcategories)) {
                $whereClause .= " AND subcategory_id = ?";
                $whereParams[] = $subcategory;
                $data['subcategoryParam'] = "&subcategory=" . $subcategory;
            } else {
                return $this->redirect("?c=categoryList");
            }
        }

        if($orderBy) {
            if (strcmp($orderBy, "ASC") == 0 || strcmp($orderBy, "DESC") == 0) {
                $orderByClause .= 'price '.$orderBy;
                $data['orderByParam'] = "&orderBy=" . $orderBy;
            } else {
                return $this->redirect("?c=categoryList");
            }
        }

        $posts= Post::getAll($whereClause, $whereParams, $orderByClause);
        $data['posts'] = $posts;

        return $this->html($data);
    }
}
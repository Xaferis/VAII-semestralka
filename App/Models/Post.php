<?php

namespace App\Models;

use App\Core\Model;

class Post extends Model
{

    protected $id;
    protected $user_id;
    protected $category_id;
    protected $subcategory_id;
    protected $title;
    protected $description;
    protected $price;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getSubcategoryId()
    {
        return $this->subcategory_id;
    }

    /**
     * @param mixed $subcategory_id
     */
    public function setSubcategoryId($subcategory_id): void
    {
        $this->subcategory_id = $subcategory_id;
    }


}
<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model {

    protected $id;
    protected $name;
    protected $image_src;

    public function getSubcategories() {
        return Subcategory::getAll('category_id = ?', [$this->getId()]);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getImageSrc()
    {
        return $this->image_src;
    }

}
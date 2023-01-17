<?php

namespace App\Models;

use App\Core\Model;

class Post_image extends Model
{

    protected $id;
    protected $post_id;
    protected $image_path;

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
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->image_path;
    }

    /**
     * @param mixed $image_path
     */
    public function setImagePath($image_path): void
    {
        $this->image_path = $image_path;
    }

    public function completeDelete() {
        unlink($this->image_path);
        $this->delete();
    }

}
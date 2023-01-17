<?php
use App\Models\Category;
use App\Models\Post;
use App\Models\Post_image;

/** @var Array $data */
/** @var Post $post */
/** @var Category[] $categories */
/** @var Post_image[] $images */

$post = $data['post'];
$categories = $data['categories'];
$first_category = array_values($categories)[0];
$images = $data['images'] ?? null;
$validClass = $post->getId() ? "valid" : "invalid";
$disabledClass = $post->getId() ? "enabled" : "disabled";
?>

<div class="container mt-2 inner-container">
    <div class="row>">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center pb-3"><?= $data['title'] ?></h5>
                    <form class="needs-validation" method="post" action="?c=posts&a=store" enctype="multipart/form-data" id="post-form" novalidate>
                        <input type="hidden" value="<?= $post->getId() ?>" name="id">

                        <?php if (isset($images)) {
                            foreach ($images as $image) { ?>
                                <input type="hidden" value="<?= $image->getImagePath() ?>" name="images_paths[]">
                            <?php   }
                        } ?>

                        <div class="form-floating mb-3">
                            <input name="title" type="text" id="title" class="form-control <?= $validClass ?>" value="<?= $post->getTitle() ?>" required onkeyup="checkPostsInputFields('title')">
                            <label for="title">Názov</label>
                            <div class="warning-message px-1 pt-1" id="warning_title" hidden>Názov nesmie byť prázdny!</div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" name="description" class="form-control <?= $validClass ?>" id="description" rows="3" onkeyup="checkPostsInputFields('description')"><?= $post->getDescription() ?></textarea>
                            <label for="description">Popis</label>
                            <div class="warning-message px-1 pt-1" id="warning_description" hidden>Popis nesmie byť prázdny!</div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select type="text" class="form-select" id="category" name="category" onchange="updateSubcategories()" required>

                                        <?php foreach ($categories as $category) { ?>
                                            <option value="<?= $category->getId() ?>" <?php if($post->getCategoryId()==$category->getId()) { echo "selected"; } ?>>
                                                <?= $category->getName() ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                    <label for="category">Kategória</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select type="text" class="form-select" id="subcategory" name="subcategory" required>

                                        <?php foreach ($first_category->getSubcategories() as $subcategory) { ?>
                                            <option value="<?= $subcategory->getId() ?>" <?php if($post->getSubcategoryId()==$subcategory->getId()) { echo "selected"; } ?>>
                                                <?= $subcategory->getDescription() ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                    <label for="subcategory">Podkategória</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input name="price" type="text" id="price" class="form-control <?= $validClass ?>" value="<?= $post->getPrice() ?>" required onkeyup="checkPostsInputFields('price')">
                                    <label for="price">Suma v €</label>
                                    <div class="warning-message px-1 pt-1" id="warning_price" hidden>Nesprávny formát! Povolené formáty: 123 123.4 123,4</div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <h6 class="border-top pt-3">Obrázky</h6>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <input name="photo[]" type="file" id="photo" class="form-control" accept=".png, .jpg, .jpeg" onchange="uploadImages()"  multiple>
                            <div class="invalid-feedback">Nesprávny formát!</div>
                        </div>
                    </div>

                    <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 mt-3" id="images-showcase">

                        <?php if (isset($images)) {
                            foreach ($images as $image) { ?>
                            <div class="col py-3 show-image">
                                <img class="img-fluid" src="<?= $image->getImagePath() ?>" alt="">
                                <button class="btn btn-danger" onclick="deletePostImageElements(this)" value="<?= $image->getImagePath() ?>">X</button>
                            </div>
                        <?php   }
                        } ?>

                    </div>

                    <div class="text-center border-top pt-3">
                        <button class="btn btn-primary" type="submit" name="submit" id="submit_button" form="post-form" <?= $disabledClass ?>>
                            <?= $data['button'] ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


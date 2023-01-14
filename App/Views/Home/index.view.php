<?php

use App\Models\Category;
use App\Models\Post;

/** @var Array $data */
/** @var Post[] $posts */
/** @var Category[] $categories */

$posts = $data['posts'];
$categories = $data['categories'];
?>

<div class="inner-container">
    <div class="image-container">
        <img src="public/images/placeholders/homepage.png" class="homepage-image" alt="">
        <div class="card-img-overlay">
            <h2>Spravte si doma poriadok a môžete na tom aj zarobiť.</h2>
            <a href="?c=posts&a=create" class="btn btn-primary">Pridať inzerát</a>
        </div>
    </div>

    <?php
    if (!empty($posts)) { ?>
        <h3 class="py-3">Najnovšie inzeráty</h3>
        <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-4 mb-4">

            <?php foreach ($posts as $post) {?>
                <div class="col">
                    <div class="card h-100">

                        <?php
                            $file_path = "public/images/placeholders/post.jpg";
                            if (count($post->getImages()) > 0) {
                              $file_path = $post->getImages()[0]->getImagePath();
                            }
                        ?>

                        <img src="<?= $file_path ?>" class="card-img-top fit-cover position-relative w-100 h-100" alt="">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->getTitle() ?></h5>
                            <p class="card-text"><?= $post->getDescription() ?></p>
                            <h5 class="card-text"><?= $post->getPrice() ?> €</h5>
                        </div>
                        <div class="card-footer text-center">
                            <a href="?c=postDetail&id=<?= $post->getId() ?>" class="btn btn-primary">Zobrazit viac</a>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <h3 class="py-3">Kategórie</h3>
    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1 justify-content-center mt-3">
        <?php foreach ($categories as $category) {?>
            <div class="col-lg-3 col-sm-6 col-xs-12 py-3">
                <div class="category-image-div">
                    <img src="<?= $category->getImageSrc() ?>" alt="Test">
                </div>
                <h4 class="fw-normal mt-2"><?= $category->getName() ?></h4>
                <ul class="list-group">
                    <?php foreach ($category->getSubcategories() as $subcategory) { ?>
                        <li><?= $subcategory->getDescription() ?></li>
                    <?php } ?>
                </ul>
                <p><a class="btn btn-secondary mt-1" href="?c=category&id=<?= $category->getId() ?>">Viac &raquo;</a></p>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <a href="?c=categoryList" class="btn btn-primary">Zobraziť všetky kategórie</a>
    </div>
</div>

<?php
use App\Models\Category;
use App\Models\Post;

/** @var Array $data */
/** @var Post[] $posts */
/** @var Category $category */

$posts = $data['posts'];
$category = $data['category'];

$subcategoryParam = $data['subcategoryParam'] ?? "";
$orderByParam = $data['orderByParam'] ?? "";
?>

<div class="filter"> <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-filter" aria-expanded="false" aria-controls="mobile-filter">Filters<span class="fa fa-filter pl-1"></span></button></div>
<div id="mobile-filter">
    <div class="py-3">
        <h5 class="p-1 border-bottom">Typ</h5>
        <div class="list-group">
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $orderByParam ?>"
               class="list-group-item list-group-item-action <?php if (!isset($data['subcategoryParam'])) { echo "active"; } ?>">
                Všetko
            </a>
            <?php
            foreach ($category->getSubcategories() as $subcategory) {?>
                <a href="?c=categoryList&a=show<?= $data['categoryParam'] . "&subcategory=" . $subcategory->getId() . $orderByParam ?>"
                   class="list-group-item list-group-item-action <?php if (strcmp($subcategoryParam,"&subcategory=" . $subcategory->getId()) == 0) { echo "active"; } ?>">
                    <?php echo $subcategory->getDescription() ?>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="py-3">
        <h5 class="p-1 border-bottom">Cena</h5>
        <div class="list-group">
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $subcategoryParam ?>"
               class="list-group-item list-group-item-action <?php if (!isset($data['orderByParam'])) { echo "active"; } ?>">
                Podľa relevantnosti
            </a>
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $subcategoryParam . "&orderBy=ASC" ?>"
               class="list-group-item list-group-item-action <?php if (strcmp($orderByParam,"&orderBy=ASC") == 0) { echo "active"; } ?>">
                Od najmenšej ceny
            </a>
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $subcategoryParam . "&orderBy=DESC" ?>"
               class="list-group-item list-group-item-action <?php if (strcmp($orderByParam,"&orderBy=DESC") == 0) { echo "active"; } ?>">
                Od najväčšej ceny
            </a>
        </div>
    </div>
</div>
<!--  end of sidebar collapsed-->

<section id="sidebar">
    <div class="py-3">
        <h5 class="p-1 border-bottom">Typ</h5>
        <div class="list-group">
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $orderByParam ?>"
               class="list-group-item list-group-item-action <?php if (!isset($data['subcategoryParam'])) { echo "active"; } ?>">
                Všetko
            </a>
            <?php
            foreach ($category->getSubcategories() as $subcategory) { ?>
                <a href="?c=categoryList&a=show<?= $data['categoryParam'] . "&subcategory=" . $subcategory->getId() . $orderByParam ?>"
                   class="list-group-item list-group-item-action <?php if (strcmp($subcategoryParam,"&subcategory=" . $subcategory->getId()) == 0) { echo "active"; } ?>">
                    <?php echo $subcategory->getDescription() ?>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="py-3">
        <h5 class="p-1 border-bottom">Zoradiť</h5>
        <div class="list-group">
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $subcategoryParam ?>"
               class="list-group-item list-group-item-action <?php if (!isset($data['orderByParam'])) { echo "active"; } ?>">
                Podľa relevantnosti
            </a>
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $subcategoryParam . "&orderBy=ASC" ?>"
               class="list-group-item list-group-item-action <?php if (strcmp($orderByParam,"&orderBy=ASC") == 0) { echo "active"; } ?>">
                Od najmenšej ceny
            </a>
            <a href="?c=categoryList&a=show<?= $data['categoryParam'] . $subcategoryParam . "&orderBy=DESC" ?>"
               class="list-group-item list-group-item-action <?php if (strcmp($orderByParam,"&orderBy=DESC") == 0) { echo "active"; } ?>">
                Od najväčšej ceny
            </a>
        </div>
    </div>
</section>

<section id="products">
    <div class="col py-3" id="category-main">
        <h1><?php echo $category->getName() ?></h1>
        <?php if (empty($posts)) { ?>
            <h6>Zatiaľ nie sú v tejto kategórii žiadne inzeráty</h6>
        <?php }
        foreach ($posts as $post) { ?>
            <div class="card my-3">
                <div class="row g-0">
                    <div class="col-md-4 position-relative">
                        <?php
                        $file_path = "public/images/placeholders/post.jpg";
                        if (count($post->getImages()) > 0) {
                            $file_path = $post->getImages()[0]->getImagePath();
                        }
                        ?>
                        <img src="<?php echo $file_path ?>" class="fit-contain w-100 h-100" alt="...">
                    </div>
                    <div class="col-md-8 category-card">
                        <div class="card-body">
                            <h5 class="card-title single-line"><?php echo $post->getTitle() ?></h5>
                            <p class="card-text single-line"><?php echo $post->getDescription() ?></p>
                            <h5 class="card-text"><?php echo $post->getPrice() ?>€</h5>
                            <a href="?c=postDetail&id=<?php echo $post->getId() ?>" class="btn btn-primary">Zobrazit viac</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
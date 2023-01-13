<?php
use App\Models\Category;
use App\Models\Post;

/** @var Array $data */
/** @var Post[] $posts */
/** @var Category $category */

$posts = $data['posts'];
$category = $data['category']
?>

<!--  sidebar collapsed   -->
<div class="filter"> <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-filter" aria-expanded="false" aria-controls="mobile-filter">Filters<span class="fa fa-filter pl-1"></span></button></div>
<div id="mobile-filter">
    <div class="py-3">
        <h5 class="p-1 border-bottom">Typ</h5>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">Všetko</a>
            <?php
            foreach ($category->getSubcategories() as $subcategory) {?>
                <a href="#" class="list-group-item list-group-item-action"><?php echo $subcategory->getDescription() ?></a>
            <?php } ?>
        </div>
    </div>
    <div class="py-3">
        <h5 class="p-1 border-bottom">Cena</h5>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action" aria-current="true">Od najmenšej</a>
            <a href="#" class="list-group-item list-group-item-action">Od najväčšej</a>
        </div>
    </div>
</div>
<!--  end of sidebar collapsed-->

<section id="sidebar">
    <div class="py-3">
        <h5 class="p-1 border-bottom">Typ</h5>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">Všetko</a>
            <?php
            foreach ($category->getSubcategories() as $subcategory) { ?>
                <a href="#" class="list-group-item list-group-item-action"><?php echo $subcategory->getDescription() ?></a>
            <?php } ?>
        </div>
    </div>
    <div class="py-3">
        <h5 class="p-1 border-bottom">Cena</h5>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action" aria-current="true">Od najmenšej</a>
            <a href="#" class="list-group-item list-group-item-action">Od najväčšej</a>
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
                        $file_path = "public/images/Placeholder_Post_Image.jpg";
                        if (count($post->getImages()) > 0) {
                            $file_path = "public/images/uploads/".$post->getImages()[0]->getFileName();
                        }
                    ?>
                    <img src="<?php echo $file_path ?>" class="fit-contain w-100 h-100" alt="...">
                </div>
                <div class="col-md-8 category-card">
                    <div class="card-body">
                        <h5 class="card-title single-line"><?php echo $post->getTitle() ?></h5>
                        <p class="card-text two-line"><?php echo $post->getDescription() ?></p>
                        <h5 class="card-text"><?php echo $post->getPrice() ?>€</h5>
                        <p class="card-text"><small class="text-muted">Pridane pred 5 dnami</small></p>
                        <a href="?c=postDetail&id=<?php echo $post->getId() ?>" class="btn btn-primary">Zobrazit viac</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>


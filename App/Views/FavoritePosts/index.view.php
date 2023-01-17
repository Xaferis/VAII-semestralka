<?php
use App\Models\Favorite_post;

/** @var Favorite_post[] $data */
?>

<h3 class="py-3">Moje obľúbené inzeráty</h3>
<div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-4 mb-4">
    <?php
    if (empty($data)) { ?>
        <h6>Nemáš zatiaľ žiadne obľúbené inzeráty.</h6>
    <?php }
    foreach ($data as $favoritePost) {
        $post = $favoritePost->getPostObject();
        ?>
        <div class="col">
            <div class="card h-100">

                <?php
                $file_path = "public/images/placeholders/post.jpg";
                if (count($post->getImages()) > 0) {
                    $file_path = $post->getImages()[0]->getImagePath();
                }
                ?>

                <img src="<?php echo $file_path ?>" class="card-img-top fit-cover position-relative w-100 h-100" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $post->getTitle() ?></h5>
                    <p class="card-text single-line"><?php echo $post->getDescription() ?></p>
                    <h5 class="card-text single-line"><?php echo $post->getPrice() ?> €</h5>
                </div>
                <div class="card-footer">
                    <a href="?c=postDetail&id=<?php echo $post->getId() ?>" class="btn btn-primary">Zobrazit viac</a>
                    <a href="?c=favoritePosts&a=delete&id=<?php echo $favoritePost->getId() ?>" class="btn btn-danger">Zmazat</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

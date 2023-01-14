<?php
use App\Models\Post;

/** @var Post[] $data */
?>

<h3 class="py-3">Moje inzeraty</h3>
<div class="row row-cols-1 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-4 mb-4">
    <?php if (empty($data)) { ?>
        <h6>Nemas zatial vytvorene ziadne inzeraty.</h6>
    <?php }
    foreach ($data as $post) {?>

        <div class="col">
            <div class="card h-100">

                <?php
                $image_path = "public/images/placeholders/post.jpg";
                if (count($post->getImages()) > 0) {
                    $image_path = $post->getImages()[0]->getImagePath();
                } ?>

                <img src="<?php echo $image_path ?>" class="card-img-top fit-cover position-relative w-100 h-100" alt="">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $post->getTitle() ?></h5>
                    <p class="card-text"><?php echo $post->getDescription() ?></p>
                    <h5 class="card-text"><?php echo $post->getPrice() ?> €</h5>
                </div>
                <div class="card-footer">
                    <a href="?c=postDetail&id=<?php echo $post->getId() ?>" class="btn btn-primary">Zobraziť</a>
                    <a href="?c=posts&a=edit&id=<?php echo $post->getId() ?>" class="btn btn-warning">Upraviť</a>
                    <a href="?c=posts&a=delete&id=<?php echo $post->getId() ?>" class="btn btn-danger">Zmazať</a>
                </div>
            </div>
        </div>

    <?php } ?>
</div>

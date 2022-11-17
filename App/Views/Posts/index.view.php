
<h3 class="py-3">Moje inzeraty</h3>
<div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
    <?php
    /** @var \App\Models\Post[] $data */
    if (empty($data)) { ?>
        <h6>Nemas zatial vytvorene ziadne inzeraty.</h6>
    <?php }
    foreach ($data as $post) {
    ?>
    <div class="col">
        <div class="card h-100">
            <img src="https://d3fvlhjanw7tsl.cloudfront.net/6e907f8c-49fe-4b4b-3b54-a0c88e169900/item" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $post->getTitle() ?></h5>
                <p class="card-text"><?php echo $post->getDescription() ?></p>
                <h5 class="card-text"><?php echo $post->getPrice() ?>€</h5>
            </div>
            <div class="card-footer">
                <a href="?c=posts&a=edit&id=<?php echo $post->getId() ?>" class="btn btn-warning">Upravit</a>
                <a href="?c=posts&a=delete&id=<?php echo $post->getId() ?>" class="btn btn-danger">Zmazat</a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

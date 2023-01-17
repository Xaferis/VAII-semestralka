<?php

use App\Core\IAuthenticator;
use App\Models\Post;
use App\Models\User;

/** @var Array $data */
/** @var Post $post */
/** @var User $user */
/** @var IAuthenticator $auth */

$post = $data['post'];
$user = $data['user'];
$images = $post->getImages();

if ($images) {
    $images_names = array_map(function ($array_item) { return $array_item->getImagePath(); }, $images);
} else {
    $images_names = array("public/images/placeholders/post.jpg");
}

$profile_image_path = "public/images/placeholders/user.png";
if ($user->getImagePath()) {
    $profile_image_path = $user->getImagePath();
}
?>
<!-- Carousel -->
<div class="row justify-content-center">
    <div id="photos" class="carousel slide col-lg-8 col-xs-12 carousel-dark" data-bs-ride="carousel">

        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <?php for($i = 0; $i < count($images_names); $i++) {?>
                <button type="button" data-bs-target="#photos" data-bs-slide-to="<?php echo $i ?>" class="<?php if ($i == 0) { echo "active"; } ?>"></button>
            <?php } ?>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item text-center active">
                <img src="<?php echo $images_names[0] ?>" alt="">
            </div>
            <?php for($i = 1; $i < count($images_names); $i++) {?>
                <div class="carousel-item text-center">
                    <img src="<?php echo $images_names[$i] ?>" alt="">
                </div>
            <?php } ?>
        </div>

        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#photos" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#photos" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>


<div class="row justify-content-center py-4">
    <div class="col-lg-8 col-xs-12">
        <h1 class="border-bottom style-bold"><?php echo $post->getTitle() ?></h1>
    </div>
    <div class="col-lg-8 col-xs-12 py-2">
        <p><?php echo $post->getDescription() ?></p>
    </div>
    <div class="col-lg-8 col-xs-12 py-2">
        <h2 class="style-bold pb-2 border-bottom"><?php echo $post->getPrice() ?>€</h2>
    </div>
    <?php if ($auth->isLogged()) { ?>
        <div class="col-lg-8 col-xs-12 py-2">
            <button class="btn <?php if ($data['isFavorite']) { echo 'btn-danger'; } else { echo 'btn-outline-primary'; } ?> w-100" id="favorite_button"
                    onclick="updateFavoriteState(<?php echo $post->getId() ?>)">
                <?php if ($data['isFavorite']) { echo 'Odstrániť z obľúbených'; } else { echo 'Pridať do obľúbených'; } ?>
            </button>
            <p class="py-3 border-bottom"></p>
        </div>
    <?php } ?>
    <div class="col-lg-8 col-xs-12">
        <h4>Pridal:</h4>
        <div class="d-flex p-3">
            <img src="<?php echo $profile_image_path ?>" alt=""
                 class="flex-shrink-0 me-3 rounded-circle" style="width:80px;height:80px;">
            <div>
                <h5><?php echo $user->getName() ?></h5>
                <p>
                    <strong>E-mail: </strong><?php echo $user->getEmail() ?><br><strong>Telefón: </strong><?php echo $user->getTelephone() ?>
                </p>
            </div>

        </div>
    </div>
</div>

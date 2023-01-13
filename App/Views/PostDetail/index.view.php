<?php
use App\Models\Post;

/** @var Post $data */

$images = $data->getImages();
if ($images) {
    $images_names = array_map(function ($array_item) {
        return "public/images/uploads/" . $array_item->getFileName();
    }, $images);
} else {
    $images_names = array("public/images/Placeholder_Post_Image.jpg");
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
                <img src="<?php echo $images_names[0] ?>">
            </div>
            <?php for($i = 1; $i < count($images_names); $i++) {?>
                <div class="carousel-item text-center">
                    <img src="<?php echo $images_names[$i] ?>">
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
        <h1 class="border-bottom style-bold"><?php echo $data->getTitle() ?></h1>
    </div>
    <div class="col-lg-8 col-xs-12 py-2">
        <p><?php echo $data->getDescription() ?></p>
    </div>
    <div class="col-lg-8 col-xs-12 py-2">
        <h2 class="style-bold pb-2 border-bottom"><?php echo $data->getPrice() ?>€</h2>
    </div>
    <div class="col-lg-8 col-xs-12 py-2">
        <a href="?c=postDetail&id=1" class="btn btn-outline-primary w-100">Pridať do obľúbených</a>
        <p class="py-3 border-bottom"></p>
    </div>
    <div class="col-lg-8 col-xs-12">
        <h4>Pridal:</h4>
        <div class="d-flex p-3">
            <img src="https://cdn.pixabay.com/photo/2016/11/18/23/38/child-1837375_960_720.png" alt="John Doe"
                 class="flex-shrink-0 me-3 rounded-circle" style="width:60px;height:60px;">
            <h5>John Doe</h5>
        </div>
    </div>
</div>

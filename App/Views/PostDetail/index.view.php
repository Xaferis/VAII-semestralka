<?php ?>
<!-- Carousel -->
<div class="row justify-content-center">
    <div id="photos" class="carousel slide col-lg-8 col-xs-12 carousel-dark" data-bs-ride="carousel">

        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#photos" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#photos" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#photos" data-bs-slide-to="2"></button>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item text-center active">
                <img src="https://d3fvlhjanw7tsl.cloudfront.net/84e3c465-2784-4ee1-d55b-1bea1cc53500/original" alt="Los Angeles">
            </div>
            <div class="carousel-item text-center">
                <img src="https://d3fvlhjanw7tsl.cloudfront.net/6e907f8c-49fe-4b4b-3b54-a0c88e169900/item" alt="Chicago">
            </div>
            <div class="carousel-item text-center">
                <img src="https://www.bazos.sk/img/2t/810/146404810.jpg?t=1673447110" alt="Chicago">
            </div>
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

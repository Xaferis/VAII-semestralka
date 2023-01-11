<?php
use App\Models\Category;

/** @var Category $data */
?>

<!--  sidebar collapsed   -->
<div class="filter"> <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-filter" aria-expanded="false" aria-controls="mobile-filter">Filters<span class="fa fa-filter pl-1"></span></button></div>
<div id="mobile-filter">
    <div class="py-3">
        <h5 class="p-1 border-bottom">Typ</h5>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">Všetko</a>
            <?php
            foreach ($data->getSubcategories() as $subcategory) {?>
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
            foreach ($data->getSubcategories() as $subcategory) { ?>
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
        <h1><?php echo $data->getName() ?></h1>
        <div class="card my-3">
            <div class="row g-0">
                <div class="col-md-4 position-relative">
                    <img src="https://d3fvlhjanw7tsl.cloudfront.net/84e3c465-2784-4ee1-d55b-1bea1cc53500/original" class="fit-contain w-100 h-100" alt="...">
                </div>
                <div class="col-md-8 category-card">
                    <div class="card-body">
                        <h5 class="card-title single-line">Zimna bunda</h5>
                        <p class="card-text two-line">Predám zimnú bundu bola vypraná a vyskusana inak nenosena Na cene sa mozme aj dohodnut Predám zimnú bundu bola vypraná a vyskusana inak nenosena Na cene sa mozme aj dohodnut</p>
                        <h5 class="card-text">50€</h5>
                        <p class="card-text"><small class="text-muted">Pridane pred 5 dnami</small></p>
                        <a href="?c=postDetail&id=1" class="btn btn-primary">Zobrazit viac</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card my-3">
            <div class="row g-0">
                <div class="col-md-4 position-relative">
                    <img src="https://d3fvlhjanw7tsl.cloudfront.net/6e907f8c-49fe-4b4b-3b54-a0c88e169900/item" class=" fit-contain w-100 h-100" alt="...">
                </div>
                <div class="col-md-8 category-card">
                    <div class="card-body">
                        <h5 class="card-title single-line">Zimna bunda</h5>
                        <p class="card-text two-line">Predám zimnú bundu bola vypraná a vyskusana inak nenosena Na cene sa mozme aj dohodnut Predám zimnú bundu bola vypraná a vyskusana inak nenosena Na cene sa mozme aj dohodnut</p>
                        <h5 class="card-text">50€</h5>
                        <p class="card-text"><small class="text-muted">Pridane pred 5 dnami</small></p>
                        <a href="?c=postDetail&id=2" class="btn btn-primary">Zobrazit viac</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


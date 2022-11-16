<?php
/** @var \App\Models\Category[] $data */
foreach ($data as $category) {
?><div class="col-lg-3 col-sm-6">
    <div class="category-image-div">
        <img src="<?php echo $category->getImageSrc() ?>" alt="Test">
    </div>
    <h4 class="fw-normal mt-2"><?php echo $category->getName() ?></h4>
    <ul class="list-group">
        <?php foreach ($category->getSubcategories() as $subcategory) { ?>
            <li><?php echo $subcategory->getDescription() ?></li>
        <?php } ?>
    </ul>
    <p><a class="btn btn-secondary mt-1" href="category.html">Viac &raquo;</a></p>
</div>
<?php } ?>
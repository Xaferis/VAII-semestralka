<?php
/** @var \App\Models\Category[] $data */
foreach ($data as $category) {
?><div class="col-lg-3 col-sm-6">
    <div class="category-image-div">
        <img src="https://d3s6lmhodxwlnt.cloudfront.net/images/categoryTransparent/fashion.png" alt="Test">
    </div>
    <h4 class="fw-normal mt-2">Moda</h4>
    <ul class="list-group">
        <li>Kosele, Obleky, Saka</li>
        <li>Doplnky a sperky</li>
        <li>Kabelky, tasky, ruksaky</li>
        <li>Saty, kostymy</li>
    </ul>
    <p><a class="btn btn-secondary mt-1" href="category.html">Viac &raquo;</a></p>
</div>
}
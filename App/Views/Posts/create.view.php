<?php
use App\Models\Category;
use App\Models\Post;

/** @var Array $data */
/** @var Post $post */
/** @var Category[] $categories */

$post = $data['post'];
$categories = $data['categories']
?>
<div class="container mt-2">
    <div class="row>">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Pridanie inzeratu</h5>
                    <div class="text-center text-danger mb-3">
                    </div>
                    <form method="post" action="?c=posts&a=store">
                        <input type="hidden" value="<?= $post->getId() ?>" name="id">
                        <div class="form-floating mb-3">
                            <input name="title" type="text" id="title" class="form-control" value="<?= $post->getTitle() ?>"
                                   required>
                            <label for="title">Nazov</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" name="description" class="form-control" id="description" rows="3"><?= $post->getDescription() ?></textarea>
                            <label for="description">Popis</label>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input name="price" type="text" id="price" class="form-control" value="<?= $post->getPrice() ?>" required>
                                    <label for="price">Suma v €</label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-floating mb-3">
                                    <select type="text" class="form-select" id="category" name="category" required>
                                        <?php foreach ($categories as $category) { ?>
                                            <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="category">Kategoria</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="submit">Vytvorit inzerat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


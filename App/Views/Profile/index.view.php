<?php
use App\Models\User;

/** @var User $data */
?>

<div class="container mt-2 inner-container">
    <div class="row>">
        <div class="col-sm-9 col-md-8 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h3 class="card-title text-center">Nastavenia profilu</h3>
                    <form class="needs-validation" method="post" action="" enctype="multipart/form-data" novalidate>

                        <h5 class="pt-3 pb-2 border-bottom">Profilový obrázok</h5>
                        <div class="d-flex p-3">
                            <img src="<?php echo $data->getImagePath() ?>" alt=""
                                 class="flex-shrink-0 me-3 rounded-circle" style="width:120px;height:120px;">
                        </div>

                        <div class="input-group my-3">
                            <input name="photo[]" type="file" id="photo" class="form-control" accept=".png, .jpg, .jpeg">
                        </div>

                        <h5 class="pt-3 pb-2 border-bottom">Osobné údaje</h5>
                        <div class="input-group my-3">
                            <span class="input-group-text">E-mail</span>
                            <input type="text" aria-label="First name" class="form-control" name="email"
                                   value="<?php echo $data->getEmail() ?>" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Prezývka</span>
                            <input type="text" aria-label="First name" class="form-control" name="nickname"
                                    value="<?php echo $data->getName() ?>">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Telefón</span>
                            <input type="text" aria-label="First name" class="form-control" name="telephone"
                                    value="<?php echo $data->getTelephone() ?>">
                        </div>
                        <div class="text-center pb-3">
                            <button class="btn btn-primary" type="submit" name="submit">Uložiť zmeny</button>
                        </div>

                    </form>

                    <form class="needs-validation" method="post" action="" novalidate>

                        <h5 class="pt-3 pb-2 border-bottom">Zmena hesla</h5>
                        <div class="input-group my-3">
                            <span class="input-group-text">Staré heslo</span>
                            <input type="text" aria-label="First name" class="form-control" name="old_password">
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text">Nové heslo</span>
                            <input type="text" aria-label="First name" class="form-control" name="new_password">
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text">Znova nové heslo</span>
                            <input type="text" aria-label="First name" class="form-control" name="new_password_repeat">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="submit">Zmeniť heslo</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
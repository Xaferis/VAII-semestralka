<?php
/** @var Array $data */
?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Prihlásenie</h5>
                    <div class="text-center text-danger mb-3">
                        <?= @$data['message'] ?>
                    </div>
                    <form class="needs-validation" method="post" action="<?= \App\Config\Configuration::LOGIN_URL ?>" novalidate>
                        <div class="form-floating mb-3">
                            <input name="login" type="email" id="login" class="form-control" required onchange="checkInputFields()">
                            <label for="login">E-mail</label>
                            <div class="invalid-feedback">Nespravny format e-mailu!</div>
                        </div>

                        <div class="form-floating mb-3">
                            <input name="password" type="password" id="password" class="form-control" required onchange="checkInputFields()">
                            <label for="password">Heslo</label>
                            <div class="invalid-feedback">Zadaj prosim heslo!</div>
                        </div>
                        <div class="text-center">
                            <p>Nemas ucet? <a href="?c=auth&a=register">Registruj sa</a></p>
                            <button class="btn btn-primary hidable" type="submit" name="submit" disabled>Prihlásiť</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

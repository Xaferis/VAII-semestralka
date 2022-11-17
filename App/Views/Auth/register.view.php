<?php
/** @var Array $data */
?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Registracia</h5>
                    <div class="text-center text-danger mb-3">
                        <?= @$data['message'] ?>
                    </div>
                    <form class="form-signin" method="post" action="?c=auth&a=register">
                        <div class="form-floating mb-3">
                            <input name="login" type="text" id="login" class="form-control" required>
                            <label for="login">E-mail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="name" type="text" id="name" class="form-control" required>
                            <label for="name">Meno</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" id="password" class="form-control" required>
                            <label for="password">Heslo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password_check" type="password" id="password_check" class="form-control" required>
                            <label for="password_check">Znova heslo</label>
                        </div>
                        <div class="text-center">
                            <p>Uz mas ucet? <a href="?c=auth&a=login">Prihlas sa</a></p>
                            <button class="btn btn-primary" type="submit" name="submit">Zaregistruj sa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
use App\Config\Configuration;

/** @var Array $data */

?>

<div class="container inner-container">

    <?php if (isset($data['message'])) {?>
        <script>
            createAlert("<?php echo $data['message'] ?>", <?php echo $data['isMessageError'] ?>)
        </script>
    <?php } ?>

    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center pb-3">Prihlásenie</h5>
                    <form class="needs-validation" method="post" action="<?= Configuration::LOGIN_URL ?>" novalidate>
                        <div class="form-floating mb-3">
                            <input name="login" type="email" id="email" class="form-control" required onkeyup="checkLoginInputFields()" ">
                            <label for="email">E-mail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" id="password" class="form-control" required onkeyup="checkLoginInputFields()">
                            <label for="password">Heslo</label>
                        </div>
                        <div class="text-center">
                            <p>Nemáš účet? <a href="?c=auth&a=register">Registrovať sa</a></p>
                            <button class="btn btn-primary" id="submit_button" type="submit" name="submit" disabled>Prihlásiť</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

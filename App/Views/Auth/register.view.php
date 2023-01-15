<?php
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
                    <h5 class="card-title text-center pb-3">Registrácia</h5>
                    <form class="needs-validation" id="needs-validation" method="post" action="?c=auth&a=register" novalidate>
                        <div class="form-floating mb-3">
                            <input name="login" type="email" id="email" class="form-control invalid" required onkeyup="checkInputField('email')">
                            <label for="email">E-mail</label>
                            <div class="warning-message px-1 pt-1" id="warning_email" hidden>Nesprávny formát e-mailu!</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="name" type="text" id="username" class="form-control invalid" required onkeyup="checkInputField('username')">
                            <label for="username">Meno</label>
                            <div class="warning-message px-1 pt-1" id="warning_username" hidden>Prezývka musí byť dlhá 4-25 znakov, musí začínať písmenom, povolené sú znaky "a-Z,1-9,_"!</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" id="password" class="form-control invalid" required onkeyup="checkInputField('password')">
                            <label for="password">Heslo</label>
                            <div class="warning-message px-1 pt-1" id="warning_password" hidden>Heslo musí mať min. 8 znakov, aspoň 1 písmeno a aspoň 1 číslicu!</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password_check" type="password" id="password_check" class="form-control invalid" required onkeyup="checkPasswords()">
                            <label for="password_check">Znova heslo</label>
                            <div class="warning-message px-1 pt-1" id="warning_password_check" hidden>Heslá sa nezhodujú!</div>
                        </div>
                        <div class="text-center">
                            <p>Už máš účet? <a href="?c=auth&a=login">Prihlásiť sa</a></p>
                            <button class="btn btn-primary" id="submit_button" type="submit" name="submit" disabled>Zaregistruj sa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
use App\Models\User;

/** @var Array $data */
/** @var User $user */

$user = $data['user'];
$image_path = "public/images/placeholders/user.png";
if ($user->getImagePath()) {
    $image_path = $user->getImagePath();
}
?>

<div class="container mt-2 inner-container">

    <?php if (isset($data['message'])) {?>
        <script>
            createAlert("<?php echo $data['message'] ?>", <?php echo $data['isMessageError'] ?>)
        </script>
    <?php } ?>

    <div class="row>">
        <div class="col-sm-9 col-md-8 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h3 class="card-title text-center">Nastavenia profilu</h3>
                    <form class="needs-validation" id="profile-form" enctype="multipart/form-data" novalidate>
                        <h5 class="pt-3 pb-2 border-bottom">Profilový obrázok</h5>
                        <div class="col-3 p-3 <?php if ($user->getImagePath()) { echo "show-image"; } ?>">
                            <img src="<?php echo $image_path ?>" alt="" id="profile-image"
                                 class="flex-shrink-0 me-3 rounded-circle" style="width:120px;height:120px;">
                            <?php if ($user->getImagePath()) { ?>
                                <button class="btn btn-danger" type="button" id="delete_button" onclick='deleteUploadedImages(this, "profile")' value="<?php echo $user->getImagePath()?>">X</button>
                            <?php  } ?>
                        </div>
                        <div class="input-group my-3">
                            <input name="photo" type="file" id="photo" class="form-control" onchange="uploadProfileImage()" accept=".png, .jpg, .jpeg">
                        </div>

                        <h5 class="pt-3 pb-2 border-bottom">Osobné údaje</h5>
                        <div class="input-group my-3">
                            <span class="input-group-text">E-mail</span>
                            <input type="text" aria-label="First name" class="form-control" name="email"
                                   value="<?php echo $user->getEmail() ?>" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Prezývka</span>
                            <input type="text" aria-label="First name" class="form-control" name="username" id="username"
                                    value="<?php echo $user->getName() ?>">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Telefón</span>
                            <input type="text" aria-label="First name" class="form-control" name="telephone" id="telephone"
                                    value="<?php echo $user->getTelephone() ?>">
                        </div>
                        <?php if ($user->getImagePath()) { ?>
                            <input type="hidden" value="<?php echo $user->getImagePath() ?>" id="file_path_input" name="file_path">
                        <?php } ?>
                    </form>

                    <div class="text-center pb-3">
                        <button class="btn btn-primary" onclick="updateProfileData()">Uložiť zmeny</button>
                    </div>

                    <form class="needs-validation" method="post" action="?c=profile&a=changePassword" novalidate>

                        <h5 class="pt-3 pb-2 border-bottom">Zmena hesla</h5>
                        <div class="input-group my-3">
                            <span class="input-group-text">Staré heslo</span>
                            <input type="password" aria-label="First name" class="form-control" name="old_password">
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text">Nové heslo</span>
                            <input type="password" aria-label="First name" class="form-control" name="new_password">
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text">Znova nové heslo</span>
                            <input type="password" aria-label="First name" class="form-control" name="new_password_repeat">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary">Zmeniť heslo</button>
                        </div>

                    </form>

                    <h5 class="pt-3 pb-2 border-bottom">Zmazanie účtu</h5>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-danger" onclick="deleteAccount()">Zmazať účet</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
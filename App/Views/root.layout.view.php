<?php
/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/styl.css">
    <script src="public/js/script.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg fixed-top bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand textLogo" href="/?c=home">BAZARIK</a>
            <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="?c=categoryList">Kategórie</a>
                    </li>
                </ul>


                <?php if ($auth->isLogged()) { ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="?c=posts&a=create">Pridať inzerát</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="?c=posts">Moje inzeráty</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?c=profile">Moj profil</a></li>
                                <li><a class="dropdown-item" href="?c=auth&a=logout">Odhlasit sa</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="?c=auth">Prihlásiť sa</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container mb-3" id="main-container">
        <div class="web-content">
            <?= $contentHTML ?>
        </div>
    </div>
    <footer class="bg-light mt-auto text-center text-md-start">
        <div class="container my-1 py-2">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-md-0">
                    <a class="textLogo" href="/?c=home">BAZARIK</a>
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste atque ea quis
                        molestias. Fugiat pariatur maxime quis culpa corporis vitae repudiandae
                        aliquam voluptatem veniam, est atque cumque eum delectus sint!
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-md-0">
                    <a class="footerTitle">Všeobecné informácie</a>

                    <ul class="list-unstyled">
                        <li><a href="#!">FAQ</a></li>
                        <li><a href="#!">Reklamačný poriadok</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-1">
                    <a class="footerTitle">Pomoc</a>
                    <ul class="list-unstyled">
                        <li><a href="?c=home&a=contact">Kontakt</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-2" id="footer-bar">
            © 2022 Copyright:
            <a href="/?c=home">bazarik.sk</a>
        </div>
    </footer>
</body>
</html>

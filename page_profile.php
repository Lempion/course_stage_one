<?php
session_start();

require 'classes/DataBase.php';

if (!$_SESSION['USER']) {
    header('Location:/');
}

$dataBase = new DataBase();

// Скорее всего нужно переписать на get параметр, чтобы получать данные любого пользователя
$dataUser = $dataBase->getDataUsers($_SESSION['USER']['email']);

if (isset($dataUser['ERROR'])) {
    $_SESSION['ANSWER'] = $dataUser;
    header('Location:/');
}

$dataUser = $dataUser[0];

echo '<pre>';
print_r($dataUser);
echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
</head>
<body class="mod-bg-1 mod-nav-link">


<?php require 'components/navbar.php'; ?>


<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i> <?php echo $dataUser['username']; ?>
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xl-6 m-auto">
            <!-- profile summary -->
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                            <img src="images/<?php echo ($dataUser['avatar']?:'default.png');?>"
                                 class="rounded-circle shadow-2 img-thumbnail" alt="" style="width: 150px;height: 150px;">
                            <h5 class="mb-0 fw-700 text-center mt-3">
                                <?php echo $dataUser['username']; ?>
                                <small class="text-muted mb-0">Toronto, Canada</small>
                            </h5>
                            <div class="mt-4 text-center demo">
                                <?php if ($dataUser['inst']): ?>
                                    <a href="https://www.instagram.com/<?php echo $dataUser['inst']; ?>" class="fs-xl"
                                       style="color:#C13584" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if ($dataUser['vk']): ?>
                                    <a href="https://vk.com/<?php echo $dataUser['vk']; ?>" class="fs-xl" style="color:#4680C2" target="_blank">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($dataUser['tg']): ?>
                                    <a href="https://t.me/<?php echo $dataUser['tg']; ?>" class="fs-xl" style="color:#0088cc" target="_blank">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 text-center">
                            <a href="tel:+<?php echo $dataUser['phone']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i> +<?php echo $dataUser['phone']; ?></a>
                            <a href="mailto:<?php echo $dataUser['email']; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?php echo $dataUser['email']; ?></a>
                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i> <?php echo $dataUser['address']; ?>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>

    $(document).ready(function () {

    });

</script>
</html>
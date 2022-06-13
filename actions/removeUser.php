<?php
session_start();

require '../classes/DataBase.php';
require '../classes/Images.php';

if (!$_GET['id'] || !$_SESSION['USER']) {
    header('Location:/');
    exit();
}

$dataBase = new DataBase();
$images = new Images();

$admin = $dataBase->checkAdmin($_SESSION['USER']['id']);

if ($_GET['id'] != $_SESSION['USER']['id'] && !$admin) {
    $_SESSION['ANSWER'] = ['ERROR' => 'У вас недостаточно прав'];
}

$result = $dataBase->removeUser($_GET['id']);

if ($result['ACCEPT'] && $_GET['avatar']) {
    $images->removeImg($_GET['avatar']);
}

if ($result['ACCEPT'] && ($_GET['id'] == $_SESSION['USER']['id'])) {
    session_destroy();
    header('Location:../registration.php');
    exit();
}

$_SESSION['ANSWER'] = $result;
header('Location:../');
exit();
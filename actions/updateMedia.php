<?php
session_start();

if (!$_SESSION['USER']) {
    header('Location:/');
}

if (!$_FILES['avatar']['tmp_name']) {
    $_SESSION['ANSWER'] = ['ERROR' => 'Ошибка загрузки файла'];
    header('Location:../media.php');
    exit();
}

require '../classes/Images.php';
require '../classes/DataBase.php';

$images = new Images();
$dataBase = new DataBase();

$fileName = $images->uploadImg($_FILES['avatar']);

if (isset($fileName['ERROR'])) {
    $_SESSION['ANSWER'] = $fileName;
    header('Location:../media.php');
    exit();
}

$dataAvatar = ['avatar' => $fileName];

$id = $_POST['id'];
unset($_POST['id']);

$updateAvatar = $dataBase->updateUser($dataAvatar, $id);

$_SESSION['ANSWER'] = $updateAvatar;
header('Location:/');

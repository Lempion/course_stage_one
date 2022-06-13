<?php
session_start();

require '../classes/Images.php';
require '../classes/DataBase.php';

if (!$_POST || !$_SESSION['USER']) {
    header('Location:/');
    exit();
} elseif (!$_FILES['avatar']['tmp_name']) {
    $_SESSION['ANSWER'] = ['ERROR' => 'Ошибка загрузки файла'];
    header('Location:../media.php');
    exit();
}

$id = $_POST['id'];
unset($_POST['id']);

$oldAvatar = $_POST['oldAvatar'];
unset($_POST['oldAvatar']);

$images = new Images();
$dataBase = new DataBase();

$fileName = $images->uploadImg($_FILES['avatar']);

if (isset($fileName['ERROR'])) {
    $_SESSION['ANSWER'] = $fileName;
    header('Location:../media.php');
    exit();
}

if ($oldAvatar){
    $images->removeImg($oldAvatar);
}

$dataAvatar = ['avatar' => $fileName];


$updateAvatar = $dataBase->updateUser($dataAvatar, $id);

$_SESSION['ANSWER'] = $updateAvatar;
header('Location:/');

<?php
session_start();

require '../classes/DataBase.php';

if (!$_POST || !$_SESSION['USER']) {
    header('Location:/');
    exit();
}

if ($_POST['password'] != $_POST['passwordConfirm']) {
    $_SESSION['ANSWER'] = ['ERROR' => 'Пароли не совпадают'];
    header('Location:../security.php');
    exit();
}

$id = $_POST['id'];
unset($_POST['id']);

$dataBase = new DataBase();

$result = $dataBase->updateSecurityInformation($_POST, $id);

if ($result['ACCEPT'] && ($id == $_SESSION['USER']['id'])) {
    $_SESSION['USER']['email'] = $_POST['email'];
}
$_SESSION['ANSWER'] = $result;

header('Location:../');

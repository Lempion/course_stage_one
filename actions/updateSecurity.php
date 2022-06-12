<?php
session_start();

require '../classes/DataBase.php';

if (!$_SESSION['USER']){
    header('Location:/');
}

if ($_POST['password'] != $_POST['passwordConfirm']){
    $_SESSION['ANSWER'] = ['ERROR'=>'Пароли не совпадают'];
    header('Location:../security.php');
    exit();
}

$dataBase = new DataBase();

$result = $dataBase->updateSecurityInformation($_POST,$_SESSION['USER']['email']);

if ($result['ACCEPT']){
    $_SESSION['USER'] = ['email' => $_POST['email']];
}
$_SESSION['ANSWER'] = $result;

header('Location:../');

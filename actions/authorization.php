<?php
session_start();

require '../classes/DataBase.php';

if (!$_POST) {
    die();
}

$dataBase = new DataBase();

$result = $dataBase->authorizationUser($_POST['email'], $_POST['password'], $_POST['rememberme']);

$_SESSION['ANSWER'] = $result;

/**
 * Проверяем есть ли у нас положительный ответ. Если да авторизуем пользователя в сессии
 * и делаем редирект на странцу пользователей.
 */
if ($result['ACCEPT']) {

$_SESSION['USER'] = $result['USER'];

unset($_SESSION['ANSWER']['USER']);

header('Location:../index.php');
exit();
}

header('Location:../login.php');
exit();


<?php
session_start();

require '../classes/DataBase.php';

if (!$_POST) {
    die();
}

$dataBase = new DataBase();

$result = $dataBase->registrationUser($_POST['email'], $_POST['password']);

/**
 * Записываем в $_SESSION['ANSWER'] ответ от нашей функции
 */
$_SESSION['ANSWER'] = $result;

/**
 * 1. Делаем проверку на ключ ACCEPT, т.к вместе с ним при успешной регистрации придёт
 * email, который нужно записать в $_SESSION['USER_EMAIL'].
 *
 * 2. Удаляем из сессии ANSWER ключ, что бы не дублировать
 *
 * 3. Делаем переход на страницу авторизации
 */
if ($result['ACCEPT']) {
    $_SESSION['USER_EMAIL'] = $result['USER_EMAIL'];
    unset($_SESSION['ANSWER']['USER_EMAIL']);

    header('Location:../login.php');
    exit();
}

header('Location:../registration.php');
exit();


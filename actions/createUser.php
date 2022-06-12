<?php
session_start();

require '../classes/DataBase.php';
require '../classes/Images.php';

$dataBase = new DataBase();
$images = new Images();

$fileName = false;

$admin = $dataBase->checkAdmin($_SESSION['USER']['id']);

if (!$admin || !$_POST) {
    header('Location:../index.php');
    exit();
}

// Создаём массив с данными пользователя
$dataPost = $_POST;

// Проверяем загружали файл или нет
if ($_FILES['avatar']['type']) {
    $fileName = $images->uploadImg($_FILES['avatar']);

    if (isset($fileName['ERROR'])) {
        $_SESSION['ANSWER'] = $fileName;
        header('Location:../create_user.php');
        exit();
    }

    // Если ошибку не выдало записываем название картинки
    $dataPost['avatar'] = $fileName;
}

/**
 * Создаём нового пользователя, в случай возвращения ERROR завершаем выполнение
 * и выводим флеш сообщение.
 * Если всё прошло успешно, обновляем запись в БД данными.
 */
$resultCreateUser = $dataBase->registrationUser($_POST['email'], $_POST['password']);

if (isset($resultCreateUser['ERROR'])) {
    $_SESSION['ANSWER'] = $resultCreateUser;
    header('Location:../create_user.php');
    exit();
}


// Нужно подготовить массив для отправки на добавление/обновление, для этого нужно убрать почту и пароль
unset($dataPost['email'],$dataPost['password']);

$updateDataUser = $dataBase->updateUser($dataPost, $resultCreateUser['USER_ID']);

$_SESSION['ANSWER'] = $updateDataUser;

header('Location:../create_user.php');
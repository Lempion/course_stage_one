<?php
session_start();

require '../classes/DataBase.php';
require '../classes/Images.php';

$dataBase = new DataBase();
$images = new Images();

$fileName = false;

$admin = $dataBase->checkAdmin($_SESSION['USER']['email']);

if (!$admin || !$_POST) {
    header('Location:../index.php');
    exit();
}

// Проверяем загружали файл или нет
if ($_FILES['avatar']['type']) {
    $fileName = $images->uploadImg($_FILES['avatar']);

    if (isset($fileName['ERROR'])) {
        $_SESSION['ANSWER'] = $fileName;
        header('Location:../create_user.php');
        exit();
    }
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

// Нужно подготовить массив для отправки на добавление, для этого нужно убрать почту и пароль
$prepareDataPost = array_values($_POST);

// Почта всегда будет под номером 4, а пароль под номером 5
unset($prepareDataPost[4], $prepareDataPost[5]);

// Полсле того как убрали эти элементы нужно восстановить порядок ключей
$dataPost = array_values($prepareDataPost);

$updateDataUser = $dataBase->updateUser($dataPost, $_POST['email'], $fileName);

$_SESSION['ANSWER'] = $updateDataUser;

header('Location:../create_user.php');
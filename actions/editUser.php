<?php
session_start();

if (!$_SESSION['USER']) {
    header('Location:/');
    exit();
}

require '../classes/DataBase.php';

$dataBase = new DataBase();

$id = $_POST['id'];
unset($_POST['id']);

$result = $dataBase->updateUser($_POST, $id);

$_SESSION['ANSWER'] = $result;

header('Location:/');
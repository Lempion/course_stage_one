<?php
session_start();

require '../classes/DataBase.php';

if (!$_POST || !$_SESSION['USER']) {
    header('Location:/');
    exit();
}

$id = $_POST['id'];
unset($_POST['id']);

$dataBase = new DataBase();

$result = $dataBase->updateUser($_POST, $id);

$_SESSION['ANSWER'] = $result;

header('Location:../');
<?php
session_start();

if (!$_POST || !$_SESSION['USER']) {
    header('Location:/');
    exit();
}

$id = $_POST['id'];
unset($_POST['id']);

require '../classes/DataBase.php';

$dataBase = new DataBase();

$result = $dataBase->updateUser($_POST, $id);

$_SESSION['ANSWER'] = $result;

header('Location:../');
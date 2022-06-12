<?php
session_start();

if (!$_SESSION['USER']){
    header('Location:/');
    exit();
}

require '../classes/DataBase.php';

$dataBase = new DataBase();

$result = $dataBase->updateUser($_POST,$_SESSION['USER']['email']);

$_SESSION['ANSWER'] = $result;

header('Location:/');
<?php

class DataBase
{
    private $db;
    private string $user = 'root';
    private string $pass = '';
    private string $hosts = 'mysql:host=localhost;dbname=course_stage_one';

    public function __construct()
    {
        $this->db = new PDO($this->hosts, $this->user, $this->pass);
    }

    public function registrationUser($email, $password): array
    {
        $sql = $this->db->prepare("SELECT * FROM `users` WHERE `email`=?");

        $sql->execute(array($email));

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return ['ERROR' => 'Этот эл. адрес уже занят другим пользователем.'];
        }

        $hashPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = ("INSERT INTO `users` (`email`,`password`) VALUES (?,?)");

        $this->db->prepare($sql)->execute([$email, $hashPass]);

        return ['ACCEPT' => 'Вы успешно зарегистрировались!', 'USER_EMAIL' => $email];
    }

    public function authorizationUser()
    {
    }


}
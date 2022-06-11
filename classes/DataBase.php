<?php

class DataBase
{
    private $db;
    private string $user = 'root';
    private string $pass = '';
    private string $hosts = 'mysql:host=localhost;dbname=course_stage_one';

    /**
     * При вызове класса, автоматически происхожит коннект с БД.
     * И в переменную $db записывается функционал для работы с базой.
     */
    public function __construct()
    {
        $this->db = new PDO($this->hosts, $this->user, $this->pass);
    }

    /**
     * Функция Регистрация пользователя
     * @param $email - почта
     * @param $password - пароль
     *
     * Возвращает массив с ответом
     * @return array|string[]
     */
    public function registrationUser($email, $password): array
    {
        $sql = $this->db->prepare("SELECT * FROM `users` WHERE `email`=?");

        $sql->execute(array($email));

        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return ['ERROR' => 'Этот эл. адрес уже занят другим пользователем.'];
        }

        $hashPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = $this->db->prepare("INSERT INTO `users` (`email`,`password`) VALUES (?,?)");

        $sql->execute([$email, $hashPass]);

        return ['ACCEPT' => 'Регистрация успешна', 'USER_EMAIL' => $email];
    }

    /**
     * Функция Авторизации пользователя
     * @param $email - почта
     * @param $password - пароль
     * @param $rememberMe - запомнить меня
     *
     * Возвращает массив с ответом
     * @return array|string[]
     */
    public function authorizationUser($email, $password, $rememberMe): array
    {
        $sql = $this->db->prepare("SELECT * FROM `users` WHERE `email`=?");

        $sql->execute(array($email));

        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return ['ERROR' => 'Данный эл.адрес не зарегистрирован'];
        }

        $resultPass = password_verify($password, $result['password']);

        if ($resultPass) {
            return ['ACCEPT' => 'Вы успешно авторизовались', 'USER' => ['email' => $email, 'pass' => $result['password']]];
        } else {
            return ['ERROR' => 'Введен не верный эл.адрес или пароль'];
        }
    }

    /**
     * Проверям роль пользователя на возможность администрирования
     * @param $email - почта авторизированного пользователя
     *
     * Возвращает true или false
     * @return boolean
     */
    public function checkAdmin($email): bool
    {
        $sql = $this->db->prepare("SELECT `role` FROM `users` WHERE `email`=?");

        $sql->execute(array($email));

        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if ($result['role'] == 1) {
            return true;
        } else {
            return false;
        }

    }

    /**\
     * @param $dataUser - массив с данными пользователя
     * @param $email - отедльное почта
     * @param $avatar - сразу наименование картинки для добавления в БД
     * @return string[]
     *      */
    public function updateUser($dataUser, $email, $avatar = false)
    {
        // Нужно сделать проверку на аватарку, т.к если она есть то нужно записать её в массив
        // и только после записать в массив почту, т.к это важно при создании sql, т.к почта всегда должна идти последней
        if ($avatar) {
            $dataUser[] = $avatar;
        }

        $dataUser[] = $email;

        // Если аватрку передали, то добавлем доп. поле, если нет то просто ставим пробел
        $sql = "UPDATE `users` SET `username`=?,`job`=?,`phone`=?,`address`=?,`status`=?,`vk`=?,`tg`=?,`inst`=?" . ($avatar ? ',`avatar`=? ' : ' ') . "WHERE `email`=?";

        $sql = $this->db->prepare($sql);

        $sql->execute($dataUser);

        $error = $sql->errorInfo();

        if (!$error[2]) {
            return ['ACCEPT' => 'Пользователь добавлен'];
        } else {
            return ['ERROR' => 'Ошибка обнолвения данных'];
        }
    }

}
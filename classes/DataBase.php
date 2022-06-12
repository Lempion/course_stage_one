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
     * @param $email - почта
     * @return string[]
     *      */
    public function updateUser($dataUser, $email)
    {
        // Создаём пустую строку для заполнения её полями на отправку
        $addFields = '';

        // Не нашёл лучше способа как проверить является ли элемент последним в при переборе в foreach
        $dataCount = count($dataUser);
        $count = 0;

        foreach ($dataUser as $item => $value) {
            $count++;
            if ($count == $dataCount) {

                $addFields .= $item . '=?';

                $sql = "UPDATE users SET " . $addFields . " WHERE email=?";

                // После того как наша строка sql готова, нужно взять только значения нашего массива с данными
                // и передать в execute. Но перед этим в послений элемент массива записать почту.
                $dataForExecute = array_values($dataUser);

                $dataForExecute[] = $email;

            } else {
                $addFields .= $item . '=?,';
            }

        }

        $sql = $this->db->prepare($sql);

        $sql->execute($dataForExecute);

        $error = $sql->errorInfo();

        if (!$error[2]) {
            return ['ACCEPT' => 'Пользователь добавлен/обновлен'];
        } else {
            return ['ERROR' => 'Ошибка обнолвения данных'];
        }

    }

    /**
     * @param $email - если передали почту, значит нужно получить 1 человека. Нет - значит всех пользователей
     *
     * При успешном получении массив с данными, ингаче ошибку
     * @return array|string[]
     */
    public function getDataUsers($email = null)
    {
        $sql = "SELECT * FROM `users`";

        if (isset($email)) {
            $sql .= " WHERE `email`=?";

            $sql = $this->db->prepare($sql);

            $sql->execute(array($email));

        } else {
            $sql = $this->db->query($sql);
        }

        $dataUsers = $sql->fetchAll(PDO::FETCH_ASSOC);

        if ($dataUsers) {
            return $dataUsers;
        } else {
            return ['ERROR' => 'Не удалось получить данные'];
        }


    }

}
<?php

class DataBase
{
    private $db;
    private string $user = 'root';
    private string $pass = '';
    private string $hosts = 'mysql:host=localhost;dbname=course_stage_one';

    public function __construct()
    {
        $this->connectDB($this->hosts,$this->user,$this->pass);
    }

    private function connectDB($hosts,$user,$pass){
        $this->db = new PDO($hosts,$user,$pass);
    }

    public function registrationUser(){}

    public function authorizationUser(){}


}
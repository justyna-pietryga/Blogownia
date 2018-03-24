<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Login.php';

session_start();

$db=DatabaseConnection::getInstance();

$email=$login=$psw="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = ($_POST["login"]);
    $psw = ($_POST["psw"]);
    $login = ($_POST["login"]);
}

$login = new Login($email,$login, $psw);

$login->login();
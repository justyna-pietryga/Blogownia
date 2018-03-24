<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/Registration.php';

session_start();

$email=$login=$psw=$psw_repeat="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = ($_POST["email"]);
    $psw = ($_POST["psw"]);
    $psw_repeat=($_POST["psw-repeat"]);
    $login = ($_POST["login"]);
    $re_captcha= ($_POST['g-recaptcha-response']);

}
$re_captcha= ($_POST['g-recaptcha-response']);
$regulation=false;
if(isset($_POST['regulation']))
{
    $regulation=true;
}

$registration= new Registration($email, $login, $psw, $psw_repeat, $regulation, $re_captcha );

$registration->register();
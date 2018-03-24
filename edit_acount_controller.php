<?php
require_once 'DatabaseConnection.php';
require_once 'model/Account.php';
require_once 'model/Detail.php';

session_start();

$currentLogin= $_SESSION['login'];
$db = DatabaseConnection::getInstance();
$sql= "SELECT ID, ID_USER FROM details WHERE ID_USER=".Account::getId($_REQUEST['login']);
$req=$db->query($sql);
$res= $req->fetch();
$idU= $res['ID_USER'];
$idD = $res['ID'];



$details= new Detail();
$details->setId($idD);
$name=$surname=$description=$new_login="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name=$_POST['name'];
    $surname=$_POST['surname'];
    $description= $_POST['description'];
    $new_login= $_POST['login'];
}

if($name!='') $details->changeName($name);
if($surname!='') $details->changeSurname($surname);
if($description!='') $details->changeDescription($description);
if($new_login!=''&$new_login!=$_SESSION['login']) Account::changeLoginDB($new_login, $idU);


//header('Location: /blogownia/view/editAccountView.php');
header('Location: '.$_SERVER['HTTP_REFERER']);

//dodac wyswietlanie zapisu badz bledu
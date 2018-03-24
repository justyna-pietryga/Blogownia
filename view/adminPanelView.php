<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="/css/edit_account_style.css" type="text/css">
    <link rel="stylesheet" href="/css/admin_panel_style.css" type="text/css">
    <?php require_once 'head_injection.php';?>

</head>
<body>
<header>
    <?php include 'menu_nav.php'; ?>
</header>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/DatabaseConnection.php';
require_once '../model/Detail.php';
require_once '../model/Account.php';
if(!isset($_SESSION['login'])) header('Location: index.php');
else{
    if(!Account::isAdmin(Account::getId($_SESSION['login']))) header('Location: '.$_SERVER['HTTP_REFERER']);
}
$currentLogin= $_SESSION['login'];
$db = DatabaseConnection::getInstance();
$sql= "SELECT ID, ID_USER FROM details WHERE ID_USER=".Account::getId($_SESSION['login']);
$req=$db->query($sql);
$res= $req->fetch();
$idU= $res['ID_USER'];
$idD = $res['ID'];
?>

<div class="container">
    <div id="additionalInfHeader">Usuń użytkownika</div>
    <?php
    $i=1;
    $users=Account::getAll();
    foreach ($users as $user){
        echo '<div class="account_item"><div class=account_name>
        <a style="text-decoration: none; color:#396e34" href="accountView.php?login='.$user->getLogin().'"</a>'.$i.'. '.$user->getLogin().'</div>
        <div class="delete_button"><a id="delete_btn" href="../admin_panel_controller.php?userId='.$user->getLogin().'" title="Delete user">
                                        <i class="fa fa-trash" aria-hidden="true" style="font-size:19px"></i></a></div> </div>';
        $i++;
    }

    ?>
</div>

</body>
</html>
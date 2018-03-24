<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="/css/edit_account_style.css" type="text/css">
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
$currentLogin= $_SESSION['login'];
$db = DatabaseConnection::getInstance();
$sql= "SELECT ID, ID_USER FROM details WHERE ID_USER=".Account::getId($_SESSION['login']);
$req=$db->query($sql);
$res= $req->fetch();
$idU= $res['ID_USER'];
$idD = $res['ID'];
?>

<form method="post" action="../edit_acount_controller.php">
    <div class="basic_account_inf_edit_container">
        <div class="form_header">Podstawowe informacje</div>
        <div class="input_container">
            <div class="edit_input"><div class="edit_item_name">Zmień login</div>
                <div class="input_field"><input type="text" name="login" value="<?php echo Account::getFromDB($idU, 'LOGIN');?>"></div></div>
            <div class="edit_input"><span class="edit_item_name">Ustaw imię </span>
                <div class="input_field"><input type="text" name="name" value="<?php echo Detail::getFromDB($idD, 'NAME');?>"></div> </div>
            <div class="edit_input"><span class="edit_item_name">Ustaw nazwisko</span>
                <div class="input_field"><input type="text" name="surname" value="<?php echo Detail::getFromDB($idD, 'SURNAME');?>"></div></div>
            <div class="edit_input"><span class="edit_item_name">Zmień opis</span>
                <div class="input_field"> <textarea class="description_text_box" name="description" ><?php echo Detail::getFromDB($idD, 'DESCRIPTION');?></textarea></div></div>
        </div>
    </div>

    <div class="basic_account_inf_edit_container">
        <div class="form_header">Dane kontaktowe</div>
        <div class="input_container">
            <div class="edit_input"><div class="edit_item_name">Ustaw email kontaktowy</div>
                <div class="input_field"><input type="text" name="email"></div></div>
            <div class="edit_input"><span class="edit_item_name">Podaj telefon kontaktowy </span>
                <div class="input_field"><input type="text" name="tel"></div> </div>
            <div class="edit_input"><span class="edit_item_name">Podaj adres kontaktowy</span>
                <div class="input_field"> <textarea class="description_text_box" name="address" style=""></textarea></div></div>
        </div>
    </div>

    <div class="basic_account_inf_edit_container">
        <div class="form_header">Social media</div>
        <div class="input_container">
            <div class="edit_input"><div class="edit_item_name">Profil facebook</div>
                <div class="input_field"><input type="text" name="fb"></div></div>
            <div class="edit_input"><span class="edit_item_name">Profil twitter </span>
                <div class="input_field"><input type="text" name="twitter"></div> </div>
            <div class="edit_input"><span class="edit_item_name">Profil youtube</span>
                <div class="input_field"> <input type="text" name="yt"></div></div>
        </div>
    </div>

    <div class="basic_account_inf_edit_container">
        <div class="form_header">Zmiana hasła</div>
        <div class="input_container">
            <div class="edit_input"><div class="edit_item_name">Podaj stare hasło</div>
                <div class="input_field"><input type="password" name="old-psw"></div></div>
            <div class="edit_input"><span class="edit_item_name">Podaj nowe hasło </span>
                <div class="input_field"><input type="password" name="new-psw"></div> </div>
            <div class="edit_input"><span class="edit_item_name">Powtórz nowe hasło</span>
                <div class="input_field"> <input type="password" name="psw-repeat"></div></div>
        </div>
    </div>

    <input type="submit" value="Zapisz">
    <div class="empty" style="height: 100px"></div>
</form>

</body>
</html>
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="../css/edit_account_style.css" type="text/css">
    <link rel="stylesheet" href="../css/admin_panel_style.css" type="text/css">
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

?>

<div class="container">
    <div id="additionalInfHeader">Użytkownicy blogowni</div>
    <?php
    $i=1;
    $users=Account::getAll();
    foreach ($users as $user){
        echo '<div class="account_item"><div class=account_name>
        <a style="text-decoration: none; color:#396e34" href="accountView.php?login='.$user->getLogin().'"</a>'.$i.'. '.$user->getLogin().'</div> </div>';
        $i++;
    }

    ?>
</div>

</body>
</html>
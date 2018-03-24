<?php

session_start();



?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once 'head_injection.php' ?>
    <link rel="stylesheet" href="../css/form.css" type="text/css">

    <script src="../jquery-3.2.1.min.js"></script>
    <script src="../js/loadProperForm.js"></script>


</head>
<body>
<header>
    <?php
    include 'menu_nav.php';
    ?>
</header>
<div id="container">
    <div id="login_button" class="form_changer_button"
         style="background: rgba(115,115,115,0.0); color:#bababa">Logowanie <i class="fa fa-pencil" aria-hidden="true"></i></div>
    <div id="registration_button" class="form_changer_button" onclick="loadContent('registerView.php')">Rejestracja</div>
    <form action="/loginProcess.php" method="post">
        <div id="login_form" class="my_form">
            <header>
                <h1 class="form_title" id="login_header">Logowanie</h1>
            </header>
                <input type="text" placeholder="login lub email" name="login" required><br>
                <input type="password" placeholder="hasło" name="psw" required><br>

            <?php
            if(isset($_SESSION['login_error'])) {
                echo '<p class="form_error">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']);
            }
            ?>

                <input type="submit" value="Zaloguj się">


        </div>
    </form>
</div>

</body>
</html>


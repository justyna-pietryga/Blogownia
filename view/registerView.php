<?php
session_start();

function setInputValue($form_name){
    if(isset($_SESSION[$form_name])){
        echo 'value='.$_SESSION[$form_name];
        unset($_SESSION[$form_name]);
    }
}

function setErrorMessage($error_name){
    if(isset($_SESSION[$error_name])) echo '<p class="form_error">'.$_SESSION[$error_name].'</p>';
    unset($_SESSION[$error_name]);
}


?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <link rel="stylesheet" href="../css/form.css" type="text/css">

    <script src="../jquery-3.2.1.min.js"></script>
    <script src="../js/loadProperForm.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php require_once 'head_injection.php' ?>

</head>
<body>
<header>
    <?php
    include 'menu_nav.php';
    ?>
</header>

<div id="container">
    <div id="login_button" class="form_changer_button" onclick="loadContent('loginView.php')"> Logowanie</div>
    <div id="registration_button" class="form_changer_button"
         style="background: rgba(168,168,168,0.0); color:#555555">Rejestracja <i class="fa fa-pencil" aria-hidden="true"></i></div>
<form action="/registration_process.php" method="post">
    <div id="register_form" class="my_form">
        <header>
            <h1 class="form_title" id="login_header">Rejestracja</h1>
        </header>
        <section>
            <input type="text" placeholder="Podaj login" name="login" required="true" '
                <?php setInputValue('form_login'); ?> '><br>
                    <?php setErrorMessage('e_login'); ?>

            <input type="text" placeholder="Podaj email" name="email" required="true"
                <?php setInputValue('form_email'); ?>><br>
                    <?php setErrorMessage('e_email'); ?>
            <input type="password" placeholder="Podaj hasło" name="psw" required="true"><br>
            <input type="password" placeholder="Powtórz hasło" name="psw-repeat" required="true"><br>
                    <?php setErrorMessage('e_psw'); ?>
            <br>
            <label>
                <input type="checkbox" name="regulation"> <span style="color: #333333">Potwierdź akceptację regulaminu</span>
            </label>
                    <?php setErrorMessage('e_reg'); ?>
            <br><br>

            <div class="g-recaptcha" data-sitekey="6LcR9zYUAAAAAIiEGMydO7yWd76xr08CG_q1az6a"></div>

                    <?php setErrorMessage('e_bot'); ?>

            <input type="submit" value="Zarejestruj się">
        </section>

    </div>
</form>
</div>

</body>
</html>
<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <link rel="stylesheet" href="../css/form.css" type="text/css">

    <script src="../jquery-3.2.1.min.js"></script>
    <script src="../js/loadProperForm.js"></script>
    <?php require_once 'head_injection.php' ?>


</head>
<body>
<header>
    <?php
    include 'menu_nav.php';
    ?>
</header>
<div id="container">
    <?php
    if(isset($_SESSION['which_form'])){
        echo '<script>
                loadContent(\''. $_SESSION['which_form'].'\');
                </script>';
        unset($_SESSION['which_form']);
    }
    else{
        echo '<script>
                loadContent(\'loginView.php\');</script>';
    }

    ?>
</div>

</body>
</html>
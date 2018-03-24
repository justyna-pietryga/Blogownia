<!-- <div id="menu_show"><i class="fa fa-bars" aria-hidden="true"></i></div> -->
<div id="pasek">
            <div id="logo"><i class="fa fa-pencil-square-o" aria-hidden="true" style="padding-left: 10px"></i>
            Blogownia</div>
            <nav id="topnav">
                <ul class="menu">
                    <li><a href="/index.php">Strona główna</a></li>
                    <li><a href="/view/allUsersView.php">Użytkownicy Blogowni</a></li>
                    <li><a href="#">Kategorie</a>
                    <ol>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/model/Category.php';

        $categories = Category::getAll();
        foreach($categories as $category){
            echo '<li><a href="/view/categoryView.php?categoryId='.Category::getId($category->getName()).'">'.$category->getName().'</a></li>';
        }

    echo /** @lang text */
    "</ol></li>";


     if(isset($_SESSION['log_in'])){
        echo '<li class="right" style="float: right"><a href="/logout.php"> Wyloguj </a></li>';
        //echo '<li class="account" style="float: right"><a href="myAccountPage.php?login='.$_SESSION['login'].'"> Moje konto ('.$_SESSION['login'].')</a></li>';
         echo '<li class="right" style="float: right"><a href="/view/accountView.php?login='.$_SESSION['login'].'"> Moje konto ('.$_SESSION['login'].')</a></li>';
     }
     else{
         echo '<li style="float: right"><a href="/view/formView.php">Zaloguj się/Załóż konto</a></li>';

     }

     ?>

</ul></nav></div>



<footer>
    <div id="footer">Copyright 2017 by Justyna Pietryga
        All rights reserved</div>
</footer>

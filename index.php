<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">


    <link rel="stylesheet" href="css/index.css" type="text/css">


   <!-- <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 320px) and (max-device-width: 500px)" href="css/mobile_menu_style.css" /> -->
    <link rel="stylesheet" type="text/css" href="css/menu_style.css" />
    <link rel="icon" href="/img/icon.ico" type="image/x-icon">

    <title>Blogownia</title>

    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Courgette|Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
<header>
    <?php
    require_once 'view/menu_nav.php';
    ?>
</header>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Account.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Detail.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Account.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/BlogEntry.php';
?>

<h1 id="title">Witamy na Blogowni!</h1>

<div class="container">

    <div class="popular_users">
        <div id="additionalInfHeader">TOP 10 Najchętniej subskrybowanych profili</div>
        <?php
        $i=1;
        $users=Account::getTheMostLiked();
        foreach ($users as $user){
            echo '<div class=account_name><a style="text-decoration: none; color:#396e34" href="view/accountView.php?login='.$user.'"</a>'.$i.'. '.$user.'</div>';
            $i++;
        }
        ?>
    </div>


    <div class="posts">
        <div id="postsHeader">Najbardziej lubiane posty</div>

        <?php

        $posts= BlogEntry::getTheBest();

        foreach ($posts as $post) {
            echo '<div class="blog_entry"">
                                <div class="entry_header">
                                <div class="title" style="font-size: 15px"><a style="text-decoration: none; color:#396e34" href="view/accountView.php?login='.Account::getLoginByID($post->getUserId()).'">'.Account::getLoginByID($post->getUserId()).'</a></div>
                                    <div class="title">' . $post->getTitle() . '</div>
                                    <div class="entry_data">' . $post->getDate() . '</div>
                                    <div class="entry_data">' . $post->getCategory() . '</div></div>';


            echo '<div class="entry_content">' . htmlspecialchars_decode($post->getContent());

            if(isset($_SESSION['login'])){
                if(Account::getLoginByID($post->getUserId())!=$_SESSION['login']){
                    if(!$post->isLiked(Account::getId($_SESSION['login']))){
                        echo '<div id="like"><div class="like"><a id="like_button" href="like_controller.php?place=index&action=like&postId='.$post->getId().'" title="Like post">
                                        <i class="fa fa-heart-o" aria-hidden="true" style="font-size:19px"></i></a> '.$post->countOfLikes().' likes</div></div>';
                    }
                    else{
                        echo '<div id="dislike" class="like"><a id="like_button" href="like_controller.php?place=index&action=dislike&postId='.$post->getId().'" title="Dislike post">
                                        <i class="fa fa-heart" aria-hidden="true" style="font-size:19px"></i></a> '.$post->countOfLikes().' likes</div>';
                    }

                }
            }
            else{
                echo '<div class="like">
                                   <i class="fa fa-heart" aria-hidden="true" style="font-size:19px"></i> '.$post->countOfLikes().' likes</div>';
            }
            echo '</div></div>';

        }
        ?>

    </div>

</body>
</html>

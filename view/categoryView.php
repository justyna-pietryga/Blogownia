<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="../css/account_style.css" type="text/css">
    <?php require_once 'head_injection.php' ?>

</head>
<body>
<header>
    <?php include 'menu_nav.php'; ?>
</header>

<div class="postsContainer" style="margin: 30px">

    <header>
        <div id="postsHeader" style="color: #2e941e"><?php echo Category::getNameByID($_GET['categoryId'])?>
    </header>

    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/model/BlogEntry.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/model/Category.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/model/Account.php';

    $posts= BlogEntry::getAllByCategory($_GET['categoryId']);

    foreach ($posts as $post){
        echo'<div class="blog_entry" style="background: rgba(226, 228, 217, 0.7); padding-bottom: 40px" >
                                <div class="entry_header">
                                    <div class="title" style="font-size: 15px"><a style="text-decoration: none; color:#396e34" href="accountView.php?login='.Account::getLoginByID($post->getUserId()).'">'.Account::getLoginByID($post->getUserId()).'</a></div>
                                    <div class="title">'.$post->getTitle().'</div>
                                    <div class="entry_data">'.$post->getDate().'</div>';

        echo '</div><div class="entry_content">'.htmlspecialchars_decode($post->getContent());

        if(isset($_SESSION['login'])){
            if(Account::getLoginByID($post->getUserId())!=$_SESSION['login']){
                if(!$post->isLiked(Account::getId($_SESSION['login']))){
                    echo '<div id="like"><div class="like"><a id="like_button" href="../like_controller.php?action=like&postId='.$post->getId().'" title="Like post">
                                        <i class="fa fa-heart-o" aria-hidden="true" style="font-size:19px"></i></a> '.$post->countOfLikes().' likes</div></div>';
                }
                else{
                    echo '<div id="dislike" class="like"><a id="like_button" href="../like_controller.php?action=dislike&postId='.$post->getId().'" title="Dislike post">
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

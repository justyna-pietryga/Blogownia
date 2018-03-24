<?php
//czemu u licha nie moglam tamtej funkcji wstawic tutej ?!!

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

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Account.php';
$account=new Account($_REQUEST['login']);

require_once $_SERVER['DOCUMENT_ROOT'].'/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Detail.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Account.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/BlogEntry.php';

if(isset($_SESSION['login']))
{
    $currentLogin= $_SESSION['login'];
}

$db = DatabaseConnection::getInstance();
$sql= "SELECT ID, ID_USER FROM details WHERE ID_USER=".Account::getId($_REQUEST['login']);
$req=$db->query($sql);
$res= $req->fetch();
$idU= $res['ID_USER'];
$idD = $res['ID'];



?>

<div class="container">
    <div class="accountInf">
        <div class="accountBasicInformation">
            <?php
            if(isset($_SESSION['login'])) {
                if ($_REQUEST['login'] == $_SESSION['login']) {

                    echo '<div id="edit">';
                    echo '<div class="edit_item"><a href="editAccountView.php" title="Edit account">
                            <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>';
                    if (Account::isAdmin($idU))
                    {
                        echo '<div class="edit_item"><a href="/view/adminPanelView.php" title="Admin panel">
                            <i class="fa fa-lock" aria-hidden="true"></i></a></div>';
                    }
                    echo '</div>';
                }


                $req_login = $_REQUEST['login'];

                if ($_REQUEST['login'] != $_SESSION['login']) {

                    if (Account::isSubscribe(Account::getId($_SESSION['login']), Account::getId($_GET['login']))) {
                        echo '<div id="unsubscribe_button"><a href="../subscribe_controller.php?action=unsubscribe&userFromId=' . Account::getId($_SESSION['login']) . '&userToId=' . Account::getId($_GET['login']) . '">Unsubscribe</a></div>';
                    } else {
                        echo '<div id="subscribe_button"><a href="../subscribe_controller.php?action=subscribe&userFromId=' . Account::getId($_SESSION['login']) . '&userToId=' . Account::getId($_GET['login']) . '">Subscribe</a></div>';
                    }
                }
            }

            ?>

            <div id="profileImage"></div>
            <div id="nameOfAccount">
                <div id="login_account"> <?php echo Account::getFromDB($idU, 'LOGIN') ?></div>
                <div id="name_account"><?php echo Detail::getFromDB($idD, 'NAME').' '.Detail::getFromDB($idD, 'SURNAME') ?> </div>
            </div>
            <div id="description"><?php echo Detail::getFromDB($idD, 'DESCRIPTION') ?></div>
            <div id="subscription">
                <div class="follow" id="followers"><span class="number"><?php Account::getFollowers($idU)?></span> :Obserwujący</div>
                <div class="follow" id="following">Obserwowani: <span class="number"><?php Account::getFollowings($idU)?></span> </div>
            </div>
        </div>

        <div class="accountAdditionalInformation">
            <header>
                <div id="additionalInfHeader">Dodatkowe Informacje</div>
            </header>
            <div id="dateOfRegistration">Na Blogowni od września 2017 roku</div>
            <div id="visitCounter">Wyświetleń: 300</div>
            <div id="contact">test@gmail.com<br>ul. Nalesnikowa 23 <br> Warszawa</div>
        </div>

        <div class="accountAdditionalInformation">
            <header>
                <div id="additionalInfHeader">Rekomendowane strony</div>
            </header>

        </div>

    </div>
    <div class="postsContainer">

        <header>
            <div id="postsHeader">Posty <?php
                if(isset($_SESSION['login'])) {
                    if ($_REQUEST['login'] == $_SESSION['login']) {

                        echo '<a id="add_button" href="/view/blog_entry_editorView.php?action=new_post" title="Add post">
                           <i class="fa fa-plus-square" aria-hidden="true" style="font-size:19px"></i></a></div>';
                    }
                }
                $req_login= $_REQUEST['login'];


                ?>
        </header>

        <?php

        $posts= BlogEntry::getAll(Account::getId($req_login));

        foreach ($posts as $post){
            echo'<div class="blog_entry">
                                <div class="entry_header">
                                    <div class="title">'.$post->getTitle().'</div>
                                    <div class="entry_data">'.$post->getDate().'</div>
                                    <div class="entry_data">'.$post->getCategory().'</div>';
            if(isset($_SESSION['login']))
            {
                if($_REQUEST['login']==$_SESSION['login']||Account::isAdmin(Account::getId($_SESSION['login']))) {

                    echo '<div style="float: right">';
                    echo '<div class="edit_buttons"><a href="/view/blog_entry_editorView.php?action=edit&postId='.$post->getId().'" title="Edit post">
                           <i class="fa fa-pencil-square" aria-hidden="true"></i></a></div>';
                    echo '<div class="edit_buttons"><a href="/post_editor_controller.php?action=delete&postId='.$post->getId().'" title="Delete post">
                           <i class="fa fa-trash" aria-hidden="true"></i></a></div>
                           <span style="clear: both"></span></div>';
                }


            }


            echo '</div><div class="entry_content">'.htmlspecialchars_decode($post->getContent());

            if(isset($_SESSION['login']) )
            {
                if($_GET['login']!=$_SESSION['login'])
                {
                    if(!$post->isLiked(Account::getId($_SESSION['login']))){
                        echo '<div id="like"><div class="like"><a id="like_button" href="/like_controller.php?action=like&postId='.$post->getId().'" title="Like post">
                                        <i class="fa fa-heart-o" aria-hidden="true" style="font-size:19px"></i></a> '.$post->countOfLikes().' likes</div></div>';
                    }
                    else{
                        echo '<div id="dislike" class="like"><a id="like_button" href="/like_controller.php?action=dislike&postId='.$post->getId().'" title="Dislike post">
                                        <i class="fa fa-heart" aria-hidden="true" style="font-size:19px"></i></a> '.$post->countOfLikes().' likes</div>';
                    }
                }
                else{
                    echo '<div class="like">
                                   <i class="fa fa-heart" aria-hidden="true" style="font-size:19px"></i> '.$post->countOfLikes().' likes</div>';
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

</div>
</div>


<script>
    function doSth(id) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("like").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "../like_controller.php?action=like&postId=" + id, true);
        xmlhttp.send();
    }
</script>

</body>
</html>
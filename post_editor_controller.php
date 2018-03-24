<?php
require_once 'DatabaseConnection.php';
require_once 'model/Account.php';
require_once 'model/BlogEntry.php';

session_start();

$currentLogin= $_SESSION['login'];
$db = DatabaseConnection::getInstance();
$user_id= Account::getId($currentLogin);

$content=$title=$categoryId="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content=$_POST['content'];
    $content=htmlspecialchars($content);
    $title= $_POST['title'];
    $categoryId=$_POST['category'];
}

//echo $title;
//echo $content;

if($_GET['action']=='new_post'){
    try
    {

        /*$sql= "INSERT INTO blog_entry VALUES (NULL, :user_id, NULL, :content , :title, 1)";
        $respond= $db->prepare($sql);

        $respond->bindParam(':user_id', $user_id);
        $respond->bindParam(':content', $content);
        $respond->bindParam(':title', $title);
        if($respond->execute()){
            $_SESSION['post_adding_succeeded']=true;
            header('Location: view/accountView.php');
        } */
        $date= new DateTime();

        $sql= "INSERT INTO blog_entry VALUES (NULL, '$user_id', CURRENT_TIMESTAMP , '$content' , '$title', '$categoryId')";

        if($db->query($sql)){
            header('Location: /view/accountView.php?login='.$_SESSION['login']);
        }

        else {
            //header('Location: view/blog_entry_editorView.php');
            //I must here display some error !!!!
            //echo $db->errorCode();
            echo 'Prawdopodobnie wpisany tekst zawiera niewskazane znaki';

        }

    }catch (Exception $e){echo $e->getMessage();}
}
else if($_GET['action']=='edit')
{
    try
    {
        $postId= $_GET['postId'];
        $sql= "UPDATE blog_entry SET CONTENT='$content' , TITLE='$title', CATEGORY_ID='$categoryId' WHERE ID='$postId'";
        if($db->query($sql)){
            header('Location: /view/accountView.php?login='.$_SESSION['login']);
        }

        else {
            //header('Location: view/blog_entry_editorView.php');
            //I must here display some error !!!!
            //echo $db->errorCode();
            echo 'Prawdopodobnie wpisany tekst zawiera niewskazane znaki';

        }

    }catch (Exception $e){echo $e->getMessage();}
}
else if($_GET['action']=='delete'){
    try
    {
        $postId= $_GET['postId'];
        $sql= "DELETE FROM blog_entry WHERE ID='$postId'";
        if($db->query($sql)){
            header('Location: /view/accountView.php?login='.$_SESSION['login']);
        }

        else {
            //header('Location: view/blog_entry_editorView.php');
            //I must here display some error !!!!
            echo $db->errorCode();

        }

    }catch (Exception $e){echo $e->getMessage();}
}




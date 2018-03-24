<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] .'/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/model/Account.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/model/BlogEntry.php';

$db= DatabaseConnection::getInstance();
$sql=$sql2='';

if(Account::isAdmin(Account::getId($_SESSION['login']))){

    try{
        $sql="DELETE FROM userr WHERE LOGIN='".$_GET['userId']."'";
        $sql2="DELETE FROM details WHERE ID_USER=".Account::getId($_GET['userId']);

        $db->beginTransaction();
        $db->query($sql);
        $db->query($sql2);
        $db->commit();

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }catch (Exception $e)
    {
        $db->rollBack();
    }

}
else {
    header('Location: /index.php');
}





//$path= __DIR__.'\view\accountView.php?login='.Account::getFromDB($_GET['userToId'], 'LOGIN');
//header('Location: '.$path);
//header('Location: '.$_SERVER['HTTP_REFERER']);
//else header('Location: blogownia/view/accountView.php?login='.Account::getLoginByID(BlogEntry::getUserIdByPostId($_GET['postId'])));
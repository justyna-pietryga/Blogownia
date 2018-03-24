<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] .'/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/model/Account.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/model/BlogEntry.php';

$db= DatabaseConnection::getInstance();
$sql='';


if($_GET['action']=='like'){
    $sql="INSERT INTO liking VALUES(NULL,".Account::getId($_SESSION['login']).",".$_GET['postId'].")";


}
else if($_GET['action']=='dislike'){
    $sql="DELETE FROM liking WHERE USER_ID=".Account::getId($_SESSION['login'])." AND BLOG_ENTRY_ID=".$_GET['postId'];
}
$respond= $db->query($sql);



//$path= __DIR__.'\view\accountView.php?login='.Account::getFromDB($_GET['userToId'], 'LOGIN');
//header('Location: '.$path);
header('Location: '.$_SERVER['HTTP_REFERER']);
//else header('Location: blogownia/view/accountView.php?login='.Account::getLoginByID(BlogEntry::getUserIdByPostId($_GET['postId'])));
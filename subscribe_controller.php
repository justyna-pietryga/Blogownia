<?php

require_once $_SERVER['DOCUMENT_ROOT'] .'/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/model/Account.php';

$db= DatabaseConnection::getInstance();
$sql='';
if($_GET['action']=='subscribe'){
    $sql="INSERT INTO subscription VALUES(NULL,".$_GET['userFromId'].",".$_GET['userToId'].")";
}
else if($_GET['action']=='unsubscribe'){
    $sql="DELETE FROM subscription WHERE USER_FROM=".$_GET['userFromId']." AND USER_TO=".$_GET['userToId'];
}
$respond= $db->query($sql);

//$path= __DIR__.'\view\accountView.php?login='.Account::getFromDB($_GET['userToId'], 'LOGIN');
//header('Location: '.$path);
//header('Location: blogownia/view/accountView.php?login='.Account::getFromDB($_GET['userToId'], 'LOGIN'));
header('Location: '.$_SERVER['HTTP_REFERER']);
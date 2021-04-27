<?php
session_start();
include("functions.php");

$db = db_connect();
$checkUser = $db->prepare("SELECT * FROM chat_accounts WHERE account_id = :id AND account_login = :login");
$checkUser->execute(array(
    'id' => $_SESSION['id'],
    'login' => $_SESSION['login']
));
$countUser = $checkUser->rowCount();
if($countUser == 0){
    $json['error'] = 'unlog';
    unset($_SESSION['time']);
    
}
?>
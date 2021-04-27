<?php
session_start();
include("../../script/functions.php");

$db = db_connect();

if(isset($_POST['message']) && !empty($_POST['message'])){
    $message = htmlspecialchars($_POST['message']);
    $date = date("d-m-y");

    try{
        $insert = $db->prepare('INSERT INTO chat_messages (id, user, time, message) VALUES (NULL, 5, :time, :message)');
        $insert->execute(array(
            "time" => $date,
            "message" => $message
        ));
    } catch (PDOException $e){
        die($e);
    }

    echo json_encode("{id: ".$_SESSION['id']."}");
} else {
    echo "Vous n'avez pas rempli tous les champs\n";
}
?>
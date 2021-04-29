<?php
session_start();
include("../../script/functions.php");

$db = db_connect();

if(isset($_POST['message']) && !empty($_POST['message'])){
    if(isset($_SESSION['id'])){
        $message = htmlspecialchars($_POST['message']);
        $date = date("H:i d-m-Y");
        $id = $_SESSION['id'];

        try{
            $insert = $db->prepare('INSERT INTO chat_messages (id, user, time, message) VALUES (NULL, :id, :time, :message)');
            $insert->execute(array(
                "id" => $id,
                "time" => $date,
                "message" => $message
            ));
        } catch (PDOException $e){
            echo json_encode("{error: ".$e."}");
        }
    } else {
        echo json_encode("{
            success: false,
            error: Vous n'etes pas connecté
        }");
    }
    
} else {
    echo "Vous n'avez pas rempli tous les champs\n";
}
?>
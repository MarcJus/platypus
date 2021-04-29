<?php
session_start();
include("../script/functions.php");

$db = db_connect();
$return = null;

if(isset($_POST['message']) && !empty($_POST['message'])){
    header("Content-Type: application/json");
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
            $return = ['success' => true];
            echo json_encode($return);
        } catch (PDOException $e){
            $return = ['success' => false, 'error' => $e];
            http_response_code(500);
            echo json_encode($return);
        }
    } else {
        $return = ['success' => false, 'error: Vous n\'etes pas connecté'];
        http_response_code(500);
        echo json_encode($return);
    }
    
} else {
    echo "Vous n'avez pas rempli tous les champs\n";
}
?>
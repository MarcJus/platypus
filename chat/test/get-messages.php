<?php
include("../../script/functions.php");
if(!empty($_GET['id'])){
    try{
        $id = (int) $_GET['id'];
        $db = db_connect();
        $requete = $db->prepare("SELECT * FROM chat_messages WHERE id > :id ORDER BY id ");
        $requete->execute(array("id" => $id));
        $message = null;
    
        while($donnees = $requete->fetch()){
            $getUser = getUserById($donnees['user'], $db);
            $donneesUser = $getUser->fetch();
            $username = $donneesUser['username'];
            $message =  '<p id="'.$donnees['id'].'"> <strong>'.$username.'</strong> : '.$donnees['message']."</php>";
        }
        $requete->closeCursor();
        echo $message;
    } catch (PDOException $e){
        echo $e;
    }
}
?>
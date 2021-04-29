<?php
session_start();
include("../../script/functions.php");
$username = null;

if(isset($_SESSION['id'])){
    $db = db_connect();
    $id = $_SESSION['id'];
    $getUser = getUserById($id, $db);
    if($getUser->rowCount() != 0){
        $donnees = $getUser->fetch();
        $username = $donnees['username'];
    } else {
        header("Location: /platypus/connexion");
        exit();
    }
} else {
    header("Location: /platypus/connexion");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styleChat.css">
        <title>Chat Test</title>
    </head>
    <body>
        <h1>Bonjour <?= $username ?></h1>
        <h2><a href="/platypus/connexion/">Changer d'utilisateur</a></h2>
        <div id="messages">
            <?php
            try{
                $db = db_connect();
                $requete = $db->query("SELECT * FROM (SELECT * FROM chat_messages ORDER BY id)T ORDER BY T.id ASC");
                while($donnees = $requete->fetch()){
                    $getUser = getUserById($donnees['user'], $db);
                    $donneesUser = $getUser->fetch();
                    $messageUser = $donneesUser['username'];
                    if($username == $messageUser){
                        echo '<p id="'.$donnees['id'].'"> <strong style="color: red">'.$messageUser.'</strong> : '.$donnees['message']."</php>";
                    } else {
                        echo '<p id="'.$donnees['id'].'"> <strong>'.$messageUser.'</strong> : '.$donnees['message']."</php>";
                    }
                }
                $requete->closeCursor();
            } catch (PDOException $e){
                die($e);
            }
            ?>
        </div>
        <form action="traitement.php" method="post">
            <label for="message">Message</label>
            <textarea name="message" id="message" cols="30" rows="10" required></textarea>
            <input type="submit" value="Envoyer" name="submit" id="submit">
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="app.js"></script>
    </body>
</html>
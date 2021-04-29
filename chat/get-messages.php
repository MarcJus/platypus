<?php
session_start();
include("../script/functions.php");
if(!empty($_GET['id'])){
    try{
        $id = (int) $_GET['id'];
        $db = db_connect();
        $requete = $db->prepare("SELECT * FROM chat_messages WHERE id > :id ORDER BY id ");
        $requete->execute(array("id" => $id));
        $message = null;
        $sessionUsername = null;
        if(isset($id)){
            $getUser = getUserById($id, $db);
            $donnees = $getUser->fetch();
            $sessionUsername = $donnees['username'];
        }

        if($requete->rowCount() != 0){
            while($donnees = $requete->fetch()){
                $getUser = getUserById($donnees['user'], $db);
                $donneesUser = $getUser->fetch();
                $username = $donneesUser['username'];
                $roles = $donneesUser['roles'];
                $jsonRoles = json_decode($roles);
                $admin = false;
                if($jsonRoles != null){$admin = in_array("admin", $jsonRoles);}
                ?> 
                <div class="message" id="<?= $donnees['id'] ?>">
                    <?php if($admin){ ?><p class="meta admin-message"><?= $username ?> <span><?= $donnees['time'] ?></span></p>
                    <?php } else { ?> <p class="meta user-message"><?= $username ?> <span><?= $donnees['time'] ?></span></p> <?php } ?>
                    <p class="text">
                        <?= $donnees['message']; ?>
                    </p>
                </div>
                <?php
            }
        }
        $requete->closeCursor();
    } catch (PDOException $e){
        echo $e;
    }
} else {
    http_response_code(400);
    header("Content-Type: application/json");
    $response = ['success' => false, 'error' => "No id specified"];
    echo json_encode($response);
}
?>
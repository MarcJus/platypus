<?php
session_start();
include("../script/functions.php");
$username = null;

if(isset($_SESSION['id'])){
    $db = db_connect();
    $id = $_SESSION['id'];
    $getUser = getUserById($id, $db);
    if($getUser->rowCount() != 0){
        $donnees = $getUser->fetch();
        $username = $donnees['username'];
    } else {
        header("Location: /connexion");
        exit();
    }
} else {
    header("Location: /connexion");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css">
  <title>Platypus Chat</title>
</head>
<body>
  <div class="chat-container">
    <header class="chat-header">
      <h1><i class="fas fa-platypus"></i>PlatypusChat</h1>
      <a href="/" class="btn">Leave Room</a>
    </header>
    <main class="chat-main">
      <div class="chat-sidebar">
        <!-- <h3><i class="fas fa-comments"></i> Room Name:</h3>
        <h2 id="room-name">Gamers</h2>
        <h3><i class="fas fa-users"></i> Users</h3>
        <ul id="users">
          <li>User1</li>
          <li>User2</li>
          <li>User3</li>
          <li>User5</li>
          <li>User6</li>
        </ul> -->
      </div>
      <div class="chat-messages">
        <?php
        $db = db_connect();
        $requete = $db->query("SELECT * FROM (SELECT * FROM chat_messages ORDER BY id)T ORDER BY T.id ASC");
        while($donnees = $requete->fetch()){
          $getUser = getUserById($donnees['user'], $db);
          $donneesUser = $getUser->fetch();
          $messageUser = $donneesUser['username'];
          $roles = $donneesUser['roles'];
          $jsonRoles = json_decode($roles);
          $admin = false;
          if($jsonRoles != null){$admin = in_array("admin", $jsonRoles);}
        ?>
        <div class="message" id="<?= $donnees['id'] ?>">
          <?php if($admin){ ?><p class="meta admin-message"><?= $messageUser?> <span><?= $donnees['time'] ?></span></p>
          <?php } else { ?> <p class="meta user-message"><?= $messageUser ?> <span><?= $donnees['time'] ?></span></p> <?php } ?>
          <p class="text">
            <?= $donnees['message']; ?>
          </p>
        </div>
        <?php } ?>
      </div>

    </main>
    <div class="chat-form-container">
      <form id="chat-form" method="POST" action="">
        <input
          id="msg"
          type="text"
          placeholder="Enter Message"
          required
          autocomplete="off"
        />
        <button class="btn" id="submit-message"><i class="fas fa-paper-plane"></i> Send</button>
      </form>
    </div>
  </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  	<script src="app.js"></script>
    <script>
    </script>
</body>
</html>
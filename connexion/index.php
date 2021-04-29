<?php
session_start();

$erreur = null;
include("../script/functions.php");

if(isset($_POST['username']) && isset($_POST['password'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])){

      $username = htmlspecialchars($_POST['username']);
      $password = sha1(htmlspecialchars($_POST['password']));

      try{
        $db = db_connect();
        $req = $db->prepare("SELECT * FROM users WHERE username = ?");
        $req->execute(array($username));
        if($req->rowCount() != 0){
          while($donnees = $req->fetch()){
            if($password == $donnees['password']){
              $_SESSION['id'] = $donnees['id'];
              header("Location: /");
              exit();
            } else {
              $erreur = "Nom d'utilisateur ou mot de passe incorrect";
            }
          } 
        } else {
          $erreur = "Nom d'utilisateur ou mot de passe incorrect";
        }
        
      } catch (Exception $e){
        $erreur = "Erreur : ".$erreur;
      }

    } else {
        $erreur = "Veuillez renseigner tous les champs";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"> </script>
  <script src="script.js" defer></script>
  <title>Connexion au Platypus Account</title>
</head>

<body>

  <div class="container">
    <div class="logo">
      <i class="far fa-user"></i>
    </div>

    <div class="tab-body" data-id="connexion">
      <form method="POST" action="">
        <div class="row">
          <i class="far fa-user"></i>
          <input type="username" class="input" placeholder="Pseudo" name="username" <?php if(isset($_POST['username'])){ ?> value="<?= $_POST['username'] ?>" <?php } ?>>
        </div>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input placeholder="Mot de Passe" type="password" class="input" name="password">
        </div>
          <!-- <button class="btn" type="button">Connexion</button> -->
          <input type="submit" value="Connexion" class="btn">
        <?php if(!empty($erreur)){ ?>
          <div class="input">
            <p style="color: red;"><?= $erreur ?></p>
          </div> <?php
        } ?>
        </form>
    </div>



    <div class="tab-footer">
      <a class="tab-link active" data-ref="connexion" href="javascript:void(0)"></a>
    </div>
  </div>
</body>
</html>
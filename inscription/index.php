<?php
session_start();
$erreur = null;
include("../script/functions.php");

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confPassword'])){
  if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confPassword'])){

    $username = htmlspecialchars($_POST['username']);
    $password = sha1(htmlspecialchars($_POST['password']));
    $confPassword = sha1(htmlspecialchars($_POST['confPassword']));
    
    if($password == $confPassword){
      try{
        $bdd = db_connect();
        $reqUser = $bdd->prepare("SELECT * FROM users WHERE username = ?");
        $reqUser->execute(array($username));
        if($reqUser->rowCount() == 0){
          $role = null;
          if($username == 'MarcJus'){
            $role = json_encode(["admin"]);
          }
          $reqInsert = $bdd->prepare("INSERT INTO users(username, password, roles) VALUES (:username, :password, :roles)");
          $reqInsert->execute(array("username" => $username, "password" => $password, "roles" => $role));
          $reqUser->execute(array($username));
          $donnees = $reqUser->fetch();
          $_SESSION['id'] = $donnees['id'];
          header("Location: /");
          exit();
        } else {
          $erreur = "Pseudo déjà utilisé";
        }
      } catch (Exception $e){
        $erreur = "Erreur : ".$e;
      }
    } else {
      $erreur = "Les deux mots de passe ne correspondent pas";
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
  <title>Création du Platypus Account</title>
</head>

<body>
 
 <div class="container">
 <div class="logo">
 <i class="far fa-user"></i>
</div>

  <div class="tab-body" data-id="inscription">
      <form action="" method="POST">
        <div class="row">
        <i class="far fa-user"></i>
          <input type="username" class="input" placeholder="Pseudo" name="username">
        </div>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input type="password" class="input" placeholder="Mot de Passe" name="password">
        </div>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input type="password" class="input" placeholder="Confirmer Mot de Passe" name="confPassword">
        </div>
        <!-- <a href="file:///D:/Site%20programation/Platypus%20website/page%20d'accueil/index.html"><button class="btn" type="button">Créer</button></a> -->
        <input type="submit" class="btn" value="Créer">
        <?php if(!empty($erreur)){ ?>
          <div class="input">
            <p style="color: red;"><?= $erreur ?></p>
          </div> <?php
        } ?>
      </form>
    </div>

     <div class="tab-footer">
      <a class="tab-link active" data-ref="inscription" href="javascript:void(0)"></a>
    </div>
  </div>
  </body>
</html>
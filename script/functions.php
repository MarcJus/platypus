<?php
/**
 * Permet de se connecter à la base de données
 * @return PDO
 */
function db_connect(){
    try{
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $db = new PDO("mysql:host=127.0.0.1;dbname=platypus", 'root', '', $pdo_options);
        return $db;
    } catch (Exception $e){
        die("Erreur : ".$e->getMessage());
    }
}

/**
 * Renvoie true si l'utilisateur est connecté, false s'il ne l'est pas
 * @return bool
 */

function user_verified(){
    return isset($_SESSION['id']);
}

/**
 * Transforme les messages avec lien en lien cliquables
 * @param string $content Le string à transformer
 * @return string
 */

function urllink(string $content){
    $content = preg_replace('#(((https?://)|(w{3}\.))+[a-zA-Z0-9&;\#\.\?=_/-]+\.([a-z]{2,4})([a-zA-Z0-9&;\#\.\?=_/-]+))#i', '<a href="$0" target="_blank">$0</a>', $content);
    if(preg_match('#<a href="www\.(.+)" target="_blank">(.+)<\/a>#i', $content)) {
		$content = preg_replace('#<a href="www\.(.+)" target="_blank">(.+)<\/a>#i', '<a href="http://www.$1" target="_blank">www.$1</a>', $content);
		preg_replace('#<a href="www\.(.+)">#i', '<a href="http://$0">$0</a>', $content);
	}
    $content = stripslashes($content);
	return $content;
}

/**
 * Renvoie en PDOStatement en récupérant un utilisateur par son id
 * @param int $id L'id de l'utilisateur
 * @param PDO $db La base de données
 * @return PDOStatement
 */

function getUserById(string $id, PDO $db){
    $getUser = $db->prepare("SELECT * FROM users WHERE id = ?");
    $getUser->execute(array($id));
    return $getUser;
}

/**
 * Renvoie en PDOStatement en récupérant un utilisateur par son pseudo
 * @param string $username Le nom d'utilisateur
 * @param PDO $db La base de données
 * @param string $table La table à parcourir
 * @param string $field La colonne de l'utilisateur
 * @return PDOStatement
 */

function getUserByUsername(string $username, PDO $db, string $table, string $field){
    $getUser = $db->prepare("SELECT * FROM ? WHERE id = ?");
    $getUser->execute(array($table, $username));
    return $getUser;
}

// $json = '{"name": "Marc"}';
// $decode = json_decode($json);
// $array = ["names" => ["first" => "Laura"]];
// $toSend = json_encode($array);
// echo $toSend;

?>
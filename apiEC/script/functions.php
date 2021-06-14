<?php

/**
 * @param string $url Url de la requete
 * @param array $headers Header de la requete
 * @param mixed $data Données de la requete
 * @return CurlHandle|false Retourne l'instance CurlHandle de la requete
 */
function curl_post_request(string $url, ?array $headers, ?mixed $data){
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    return $ch;
}

/**
 * Permet de se connecter à la base de données
 * @return PDO
 */
function db_connect(){
    try{
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $db = new PDO("mysql:host=localhost;dbname=khxnrprh_platypus", 'khxnrprh_marc', 'PlatypusSte15', $pdo_options);
        return $db;
    } catch (Exception $e){
        die("Erreur : ".$e->getMessage());
    }
}

?>
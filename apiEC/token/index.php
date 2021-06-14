<?php

require "../script/functions.php";
$url = "https://api.ecoledirecte.com/v3/login.awp";
$headers = array(
    "Accept: application/json",
    "Content-Type: application/x-www-form-urlencoded"
);
$data = "";
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $data = 'data={ "identifiant": "'.$username.'", "motdepasse": "'.$password.'" }';
    }
}
 else {
    http_response_code(400);
    echo "Mauvaise methode !";
    exit();
}
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$curl_exec = curl_exec($ch);

$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($curl_exec, 0, $headerSize);
$body = substr($curl_exec, $headerSize);

curl_close($ch);
$json = json_decode($body, true);
$type = $json['data']['accounts'][0]['typeCompte'];
if($type == "E"){
    $response = array("token" => $json['token'], "id" => $json['data']['accounts'][0]['id']);
    header("Content-Type: application/json");
    if($response['token'] == ""){
        $bodyJson = json_decode($body, true);
        $erreur = null;
        http_response_code(500);
        if($bodyJson['message'] == "Mot de passe invalide !"){
            $erreur = json_encode(array("erreur" => $bodyJson['message']));
            echo $erreur;
        } else {
            $erreur = json_encode(array("erreur" => "erreur inconnue"));
        }
    } else {
?>
    <?= json_encode($response) ?>
<?php } 
} else {
    echo json_encode(array("erreur" => "Vous n'etes pas un eleve"));
}?>
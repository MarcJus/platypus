<?php
header("Content-Type: application/json");
if(!empty($_POST['username']) && !empty($_POST['password'])){
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $curl_get_token = curl_init("https://platypus.go.yj.fr/apiEC/token/");
    $data_post_token = array("username" => $username, "password" => $password);

    curl_setopt($curl_get_token, CURLOPT_POST, true);
    curl_setopt($curl_get_token, CURLOPT_POSTFIELDS, $data_post_token);
    curl_setopt($curl_get_token, CURLOPT_RETURNTRANSFER, 1);

    $response_get_token = curl_exec($curl_get_token);
    curl_close($curl_get_token);
    $json_get_token = json_decode($response_get_token, true);
    $token = $json_get_token['token'];
    $id = $json_get_token['id'];

    if(!isset($_GET['date'])){
        $url = "https://api.ecoledirecte.com/v3/Eleves/".$id."/cahierdetexte.awp?verbe=get&";

        $curl_get_devoirs = curl_init($url);
        curl_setopt($curl_get_devoirs, CURLOPT_POST, true);
        curl_setopt($curl_get_devoirs, CURLOPT_POSTFIELDS, 'data={ "token": "'.$token.'" }');
        curl_setopt($curl_get_devoirs, CURLOPT_RETURNTRANSFER, true);
        
        $response_devoirs = curl_exec($curl_get_devoirs);
        curl_close($curl_get_devoirs);

        $json_devoirs = json_decode($response_devoirs, true);
        $data = $json_devoirs['data'];
        $response = array();

        $current_date = date("Y-m-d");
        $keys_day = array_keys($data);
        foreach($keys_day as $day){
            // if($day == $current_date) continue;
            // $devoir = array("day" => $day, "devoirs" => $data[$day]);
            // array_push($response, $devoir);
            $curl_get_devoirs_jour = curl_init("https://api.ecoledirecte.com/v3/Eleves/".$id."/cahierdetexte/".$day.".awp?verbe=get");
            curl_setopt($curl_get_devoirs_jour, CURLOPT_POST, true);
            curl_setopt($curl_get_devoirs_jour, CURLOPT_POSTFIELDS, 'data={ "token": "'.$token.'" }');
            curl_setopt($curl_get_devoirs_jour, CURLOPT_RETURNTRANSFER, 1);
        
            $response_get_devoirs_jour = curl_exec($curl_get_devoirs_jour);
            curl_close($curl_get_devoirs_jour);
            $json_get_devoirs_jour = json_decode($response_get_devoirs_jour, true);

            $data_jour = $json_get_devoirs_jour['data'];
            $devoirs_liste = $data_jour['matieres'];
            foreach($devoirs_liste as $devoir){
                if(isset($devoir['aFaire']['contenu'])){
                    $devoir_base64 = $devoir['aFaire']['contenu'];
                    $devoirDecoded = decodeBase64($devoir_base64);
                    $devoir['aFaire']['contenu'] = $devoirDecoded;
                    $devoir['day'] = $day;
                    array_push($response, $devoir);
                }
            }
        }
        echo json_encode($response);
    } else {
        $day = $_GET['date'];
        $response = array();
        $curl_get_devoirs_jour = curl_init("https://api.ecoledirecte.com/v3/Eleves/".$id."/cahierdetexte/".$day.".awp?verbe=get");
        curl_setopt($curl_get_devoirs_jour, CURLOPT_POST, true);
        curl_setopt($curl_get_devoirs_jour, CURLOPT_POSTFIELDS, 'data={ "token": "'.$token.'" }');
        curl_setopt($curl_get_devoirs_jour, CURLOPT_RETURNTRANSFER, 1);

        $response_get_devoirs_jour = curl_exec($curl_get_devoirs_jour);
        curl_close($curl_get_devoirs_jour);
        $json_get_devoirs_jour = json_decode($response_get_devoirs_jour, true);

        $data_jour = $json_get_devoirs_jour['data'];
        $devoirs_liste = $data_jour['matieres'];
        foreach($devoirs_liste as $devoir){
            if(isset($devoir['aFaire']['contenu'])){
                $devoir_base64 = $devoir['aFaire']['contenu'];
                $devoirDecoded = decodeBase64($devoir_base64);
                $devoir['aFaire']['contenu'] = $devoirDecoded;
                $devoir['day'] = $day;
                array_push($response, $devoir);
            }
        }
        echo json_encode($response);
    }
    

} else {
    $error = json_encode(array("erreur" => "Nom d'utilisateur ou mot de passe manquant"));
    http_response_code(400);
    echo $error;
}
/**
 * @return string Retourne le texte decode
 */
function decodeBase64(string $str, bool $stripTags = true){
    $decoded = str_replace("\n", " ", base64_decode($str));
    $decoded = html_entity_decode($decoded, ENT_QUOTES);
    if($stripTags){
        $decoded = strip_tags($decoded);
    }
    return $decoded;
}

/**
 * @return array Retourne la liste des devoirs pour le jour donné
 */
function getDevoirsJour(string $day, int $id, string $token){
    $response = array();
    $curl_get_devoirs_jour = curl_init("https://api.ecoledirecte.com/v3/Eleves/".$id."/cahierdetexte/".$day.".awp?verbe=get");
    curl_setopt($curl_get_devoirs_jour, CURLOPT_POST, true);
    curl_setopt($curl_get_devoirs_jour, CURLOPT_POSTFIELDS, 'data={ "token": "'.$token.'" }');
    curl_setopt($curl_get_devoirs_jour, CURLOPT_RETURNTRANSFER, 1);

    $response_get_devoirs_jour = curl_exec($curl_get_devoirs_jour);
    curl_close($curl_get_devoirs_jour);
    $json_get_devoirs_jour = json_decode($response_get_devoirs_jour, true);

    $data_jour = $json_get_devoirs_jour['data'];
    $devoirs_liste = $data_jour['matieres'];
    foreach($devoirs_liste as $devoir){
        if(isset($devoir['aFaire']['contenu'])){
            $devoir_base64 = $devoir['aFaire']['contenu'];
            $devoirDecoded = decodeBase64($devoir_base64);
            $devoir['aFaire']['contenu'] = $devoirDecoded;
            $devoir['day'] = $day;
            array_push($response, $devoir);
        }
    }
    return $response;
}
?>
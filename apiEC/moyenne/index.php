<?php
header("Content-Type: application/json");
if(!empty($_POST['username']) && !empty($_POST['password'])){
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if(isset($_GET['periode'])){
        $codePeriode = $_GET['periode'];
        if($codePeriode == "A001" || $codePeriode == "A002" || $codePeriode || "A003" || $codePeriode == "A999Z"){
            $curl_get_token = curl_init("https://platypus.go.yj.fr/apiEC/token/");
            $data = array("username" => $username, "password" => $password);

            curl_setopt($curl_get_token, CURLOPT_POST, true);
            curl_setopt($curl_get_token, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl_get_token, CURLOPT_RETURNTRANSFER, 1);

            $response_get_token = curl_exec($curl_get_token);
            curl_close($curl_get_token);
            $json_get_token = json_decode($response_get_token, true);
            if(isset($json_get_token['erreur'])){
                echo json_encode(array("erreur" => $json_get_token['erreur']));
                exit();
            }
            $token = $json_get_token['token'];
            $id = $json_get_token['id'];

            $url = "https://api.ecoledirecte.com/v3/eleves/".$id."/notes.awp?verbe=get&";

            $curl_get_notes = curl_init($url);
            curl_setopt($curl_get_notes, CURLOPT_POST, true);
            curl_setopt($curl_get_notes, CURLOPT_POSTFIELDS, 'data={ "token": "'.$token.'" }');
            curl_setopt($curl_get_notes, CURLOPT_RETURNTRANSFER, true);
            
            $response_notes = curl_exec($curl_get_notes);
            curl_close($curl_get_notes);
            $json_get_notes = json_decode($response_notes, true);
            $data = $json_get_notes['data'];
            $periodes = $data['periodes'];
            $response = null;
            foreach($periodes as $periode){
                if($periode['idPeriode'] == $codePeriode){
                    $response = $periode['ensembleMatieres']['moyenneGenerale'];
                }
            }

            echo $response;
        } else {
            http_response_code(400);
            echo json_encode(array("erreur" => "Mauvaise periode"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("erreur" => "Periode non specifié"));
    }
} else {
    $error = json_encode(array("erreur" => "Nom d'utilisateur ou mot de passe manquant"));
    http_response_code(400);
    echo $error;
}

?>
<?php
if(!empty($_POST['username']) && !empty($_POST['password'])){
    if(isset($_GET['id'])){
        $file_id = $_GET['id'];
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $curl_get_token = curl_init("https://platypus.go.yj.fr/apiEC/token/");
        $data = array("username" => $username, "password" => $password);

        curl_setopt($curl_get_token, CURLOPT_POST, true);
        curl_setopt($curl_get_token, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_get_token, CURLOPT_RETURNTRANSFER, 1);

        $response_get_token = curl_exec($curl_get_token);
        curl_close($curl_get_token);
        $json_get_token = json_decode($response_get_token, true);
        $token = $json_get_token['token'];
        
        $url = "https://api.ecoledirecte.com/v3/telechargement.awp?verbe=get";
        $data_download = array("leTypeDeFichier" => "FICHIER_CDT", "fichierId" => $file_id, "token" => $token, "anneeMessages" => null);
        $curl_download = curl_init($url);
        curl_setopt($curl_download, CURLOPT_HEADER, array("Content-Type: application/x-www-form-urlencoded"));
        curl_setopt($curl_download, CURLOPT_POST, true);
        curl_setopt($curl_download, CURLOPT_POSTFIELDS, $data_download);
        curl_setopt($curl_download, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_download, CURLOPT_NOBODY, false);

        $output = curl_exec($curl_download);

        $headerSize = curl_getinfo($curl_download, CURLINFO_HEADER_SIZE);
        $header = substr($output, 0, $headerSize);
        $body = substr($output, $headerSize);

        curl_close($curl_download);
        $header = rtrim($header);
        $data = explode("\n", $header);
        /**
         * @var string filename=""
         */
        $file_name = "";
        array_shift($data);
        foreach($data as $part){
            $middle = explode(":", $part);
            if(!isset($middle[1])){$middle[1] = null;}
            if($middle[0] == "content-disposition"){
                $middle_file = explode(";", $middle[1]);
                $file_name = $middle_file[1];
            }
        }
        echo $file_name;
        if(strpos($file_name, "filename*=UTF-8''") ==! false){
            echo "contains";

        } else {
            $file_name_header = explode('"', $file_name);
            $file_name_complete = explode(".", $file_name_header[1]);
            $file_name_extension = $file_name_complete[1];
            switch ($file_name_extension) {
                case "pdf":
                    header("Content-Type: application/pdf");
                    break;
                case "mp4":
                    header("Content-Type: video/mp4");
                    header("Accept-Ranges: bytes");
                    $transfer = transfer_video($body, $file_name_header[1]);
                    echo $transfer;
                    break;
                case "mp3":
                    header("Content-Type: application/mpeg");
                    break;
                case "jpg":
                    header("Content-Type: application/jpeg");
                    break;
                default:
                    break;
            }
            header("Content-Disposition: Attachement; filename=".$file_name_header[1]);
            echo $body;
        }
    } else {
        header("Content-Type: application/json");
        echo json_encode(array("erreur" => "id non specifie"));
    }
}

/**
 * @param string $data Fichier à transférer
 * @param string $name Nom de la vidéo
 * @param string $destination [optional] Destination du fichier
 * @return int|false Retourne si le fichier a bien ete ecrit
 */
function transfer_video(string $data, string $name, string $destination = ""){
    $destination = "video/".$name;
    $file = fopen($destination, "wb");
    $success = fwrite($file, $data);
    fclose($file);
    echo $success;
    return $success;
}
?>
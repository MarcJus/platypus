<?php
$method = $_SERVER['REQUEST_METHOD'];
if($method == "POST"){
    http_response_code(400);
    echo "Bad Request";
}
?>
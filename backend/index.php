<?php

require_once 'config/handleMethods.php';
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

$requestMethod = $_SERVER['REQUEST_METHOD'];
$method = isset($_POST['METHOD']) ? $_POST['METHOD'] : $requestMethod;

switch($method){
    case 'GET':
        handleGetRequest();
        break;

    case 'POST':
        handlePostRequest();
        echo("insercion correcta");
        break;
    
    case 'PUT':
        handlePutRequest();
        break;
    
    case 'DELETE':
        handleDeleteRequest();
        break;
    

    default:
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["error" => "Bad Request"]);
        break;
}   







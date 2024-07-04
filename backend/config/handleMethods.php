<?php 
require_once 'methods.php';
function handleGetRequest() {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id'])?$_GET['id']:0;
        $sql = "SELECT * FROM alumnos WHERE id = :id";
        $params = [':id' => $id];
        $result = getMethod($sql, $params);

        // Verificar si se obtuvo un resultado válido
        if ($result !== false && $result->rowCount() > 0) {
            $data = $result->fetch(PDO::FETCH_ASSOC);
            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        } else {
            // Manejar el caso donde no se encontró ningún registro
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error" => "Registro no encontrado."));
            exit();
        }
    } else {
        $sql = "SELECT * FROM alumnos";
        $result = getMethod($sql);

        // Verificar si se obtuvo un resultado válido
        if ($result !== false && $result->rowCount() > 0) {
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        } else {
            // Manejar el caso donde no se encontraron registros
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error" => "No se encontraron registros."));
            exit();
        }
    }
}


function handlePostRequest() {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $apellido = htmlspecialchars($_POST["apellido"]);
    $correo = filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL);
    $telefono = htmlspecialchars($_POST["telefono"]);
    $foto_URL = handlePicture($_FILES["foto"]);

    // Verificar si se subió correctamente la foto
    if ($foto_URL === null) {
        // Manejar error de subida de foto
        echo json_encode(array("error" => "Error al subir la foto."));
        header("HTTP/1.1 400 Bad Request");
        exit();
    }

    // Preparar consulta SQL para inserción de datos
    $sql = "INSERT INTO alumnos (nombre, apellido, correo, telefono, foto_URL) 
            VALUES (:nombre, :apellido, :correo, :telefono, :foto_URL)";
    $params = [
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':foto_URL' => $foto_URL
    ];

    // Ejecutar consulta utilizando tu método postMethod() (asumiendo que está definido)
    $result = postMethod($sql, $params);

    // Devolver respuesta en formato JSON
    echo json_encode($result);
    header("HTTP/1.1 201 Created");
    exit();
}

 
 function handlePutRequest(){
     parse_str(file_get_contents("php://input"), $_PUT);
     $nombre = htmlspecialchars($_POST["nombre"]);
    $apellido = htmlspecialchars($_POST["apellido"]);
    $correo = filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL);
    $telefono = htmlspecialchars($_POST["telefono"]);
   
    $sql = "UPDATE alumnos SET nombre = :nombre, apellido = :apellido, correo =:correo, telefono =:telefono";
    $params =[
      ':nombre' => $nombre,
      ':apellido' => $apellido,
      ':correo'=>$correo,
      ':telefono' => $telefono
    ];
    
 
    $result = putMethod($sql, $params);
     echo json_encode($result);
     header("HTTP/1.1 200 OK");
     exit();
 }
 
 function handleDeleteRequest() {
     parse_str(file_get_contents("php://input"), $_DELETE);
     $id = $_GET['id'];
     $sql = "DELETE FROM alumnos WHERE id = :id";
     $params = [':id' => $id];
     $result = deleteMethod($sql, $params);
     echo json_encode($result);
     header("HTTP/1.1 200 OK");
     exit();
 }
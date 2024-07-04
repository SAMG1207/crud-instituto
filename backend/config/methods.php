<?php
require_once 'connection.php';
function getMethod($sql, $params = []) {
    try {
        connect(); // Función para conectar a la base de datos
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute($params);
        close(); // Función para cerrar la conexión a la base de datos
        return $stmt;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function postMethod($sql, $params) {
    try {
        connect();
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute($params);
        $id = $GLOBALS['pdo']->lastInsertId(); // Obtener el ID del último registro insertado
        close();
        return ['id' => $id];
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function putMethod($sql, $params) {
    try {
        connect();
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute($params);
        close();
        return ['status' => 'success'];
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function deleteMethod($sql, $params) {
    try {
        connect();
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute($params);
        close();
        return ['status' => 'success'];
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function handlePicture($file) {
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Obtener la extensión del archivo
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // Extensiones permitidas
    $allowed = array("jpg", "jpeg", "png");

    // Validar extensión
    if (!in_array($fileActualExt, $allowed)) {
        return null; // Extensión no permitida
    }

    // Validar errores en la subida
    if ($fileError !== 0) {
        return null; // Error en la subida del archivo
    }

    // Validar tamaño del archivo (500KB)
    if ($fileSize > 500000) {
        return null; // Tamaño de archivo demasiado grande
    }

    // Nombre único para el archivo
    $fileNameNuevo = uniqid('', true) . "." . $fileActualExt;
    $fileDestination = "../backend/imgs/" . $fileNameNuevo;

    // Mover archivo a la ubicación deseada
    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        return $fileDestination; // Devuelve la URL del archivo subido
    } else {
        return null; // Error al mover el archivo
    }
}
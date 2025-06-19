<?php
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $password = $_POST['password'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $rol = 'cobrador';

    // Validar si el asesor ya existe
    $sql = "SELECT * FROM asesores WHERE nombre = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre]);

    if ($stmt->rowCount() > 0) {
        header('Location: ../view/registro_asesor.php?error=true');
        exit();
    }

    // Validar si el nombre de usuario ya está en uso
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre_usuario]);

    if ($stmt->rowCount() > 0) {
        header('Location: ../view/registro_asesor.php?error_usuario=true');
        exit();
    }

    // Crear número asesor
    $numero_asesor = 'A' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 7));

// Insertar asesor con nombre de usuario asignado
$sql = "INSERT INTO asesores (nombre, contacto, nombre_usuario) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nombre, $contacto, $nombre_usuario]);

    // Insertar usuario
    $sql = "INSERT INTO usuario (nombre_usuario, password, rol) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre_usuario, $password, $rol]);

    header('Location: ../view/registro_asesor.php?success=true');
    exit();
}
?>

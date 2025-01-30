<?php
// Conexión a la base de datos
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];

    // Validar que el nombre no exista
    $sql = "SELECT * FROM asesores WHERE nombre = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre]);

    if ($stmt->rowCount() > 0) {
        // Si el asesor ya existe
        header('Location: ../view/registro_asesor.php?error=true');
        exit();
    }

    // Generar el número de asesor aleatorio
    $numero_asesor = 'A' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 7));  // Ejemplo: A1D2F3G

    // Insertar el nuevo asesor
    $sql = "INSERT INTO asesores (nombre, contacto, numero_asesor) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $contacto, $numero_asesor]);

    // Crear el nombre de usuario: reemplazar espacios por guiones bajos
    $nombre_usuario = strtoupper(substr($nombre, 0, 1)) . $numero_asesor;

    // La contraseña será el número de asesor
    $password = $numero_asesor; // La contraseña será el número de asesor

    // Insertar el nuevo usuario para el asesor
    $rol = 'cobrador'; // Rol del nuevo usuario
    $sql = "INSERT INTO usuario (nombre_usuario, password, rol) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre_usuario, $password, $rol]);

    // Redirigir a la lista de asesores con mensaje de éxito
    header('Location: ../view/registro_asesor.php?success=true');
    exit();
}

?>

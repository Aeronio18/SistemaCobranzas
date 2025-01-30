<?php
// Incluir conexión a la base de datos
include '../database/db.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asesor_id = $_POST['asesor_id'];

    // Obtener los datos del asesor
    $sql = "SELECT * FROM asesores WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$asesor_id]);
    $asesor = $stmt->fetch();

    if ($asesor) {
        // Cambiar el estado del asesor a 'inactivo'
        $sql = "UPDATE asesores SET estado = 'inactivo' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$asesor_id]);

        // Eliminar el usuario y contraseña del asesor en la tabla 'usuario'
        $usuario = str_replace(' ', '_', $asesor['nombre']); // Reemplaza los espacios por guiones bajos
        $sql = "DELETE FROM usuario WHERE nombre_usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario]);

        // Redirigir al listado de asesores con mensaje de éxito
        header('Location: ../view/cobradores.php?status=baja');
        exit();
    } else {
        // Si no se encuentra el asesor
        header('Location: ../view/cobradores.php?status=error');
        exit();
    }
}
?>

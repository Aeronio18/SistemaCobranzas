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

        // Crear el nombre de usuario con la primera letra del nombre y el número de asesor
        $usuario = strtolower(substr($asesor['nombre'], 0, 1)) . $asesor['numero_asesor']; // Primera letra del nombre + número de asesor

        // Eliminar el usuario y contraseña del asesor en la tabla 'usuario'
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

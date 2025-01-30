<?php
// Conexión a la base de datos
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_termino = $_POST['fecha_termino'];
    $importe = $_POST['importe'];
    $abono = $_POST['abono'];

    // Insertar en la base de datos
    $sql = "INSERT INTO creditos (cliente_id, fecha_inicio, fecha_termino, importe, abono) 
            VALUES (:cliente_id, :fecha_inicio, :fecha_termino, :importe, :abono)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cliente_id' => $cliente_id,
        ':fecha_inicio' => $fecha_inicio,
        ':fecha_termino' => $fecha_termino,
        ':importe' => $importe,
        ':abono' => $abono
    ]);

    // Redirigir con mensaje de éxito
    echo "<script>
        alert('Crédito registrado correctamente.');
        window.location.href = 'creditos.php';
    </script>";
}
?>

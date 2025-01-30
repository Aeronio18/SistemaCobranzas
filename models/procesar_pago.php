<?php
// Incluir la conexión a la base de datos
include '../database/db.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los valores del formulario
    $credito_id = $_POST['credito_id'];
    $monto_pago = $_POST['monto_pago'];
    $fecha_pago = $_POST['fecha_pago'];
    $metodo_pago = $_POST['metodo_pago'];

    try {
        // Iniciar una transacción para asegurar que ambas acciones se realicen correctamente
        $pdo->beginTransaction();

        // Insertar el pago en la base de datos
        $query = "INSERT INTO pagos (credito_id, monto, fecha_pago, metodo_pago)
                  VALUES (:credito_id, :monto, :fecha_pago, :metodo_pago)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'credito_id' => $credito_id,
            'monto' => $monto_pago,
            'fecha_pago' => $fecha_pago,
            'metodo_pago' => $metodo_pago
        ]);

        // Actualizar el campo "abono" en la tabla "creditos"
        // Obtener el abono y saldo pendiente actuales para ese crédito
        $query = "SELECT abono, saldo_pendiente FROM creditos WHERE id = :credito_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['credito_id' => $credito_id]);
        $credito = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($credito) {
            // Calcular el nuevo abono
            $nuevo_abono = $credito['abono'] + $monto_pago;
            // Calcular el nuevo saldo pendiente
            $nuevo_saldo = $credito['saldo_pendiente'] - $monto_pago;

            // Actualizar el campo "abono" y "saldo_pendiente" en la tabla "creditos"
            $query = "UPDATE creditos SET abono = :nuevo_abono, saldo_pendiente = :nuevo_saldo WHERE id = :credito_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'nuevo_abono' => $nuevo_abono,
                'nuevo_saldo' => $nuevo_saldo,
                'credito_id' => $credito_id
            ]);

            // Si el saldo pendiente es 0, actualizar el estado a "pagado"
            if ($nuevo_saldo <= 0) {
                $query = "UPDATE creditos SET estado = 'pagado' WHERE id = :credito_id";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['credito_id' => $credito_id]);
            }
        }

        // Confirmar la transacción
        $pdo->commit();

        // Redirigir a la página del historial de pagos
        header("Location: ../view/historial_pagos.php?credito_id=$credito_id");
        exit;
    } catch (PDOException $e) {
        // Si ocurre algún error, deshacer la transacción
        $pdo->rollBack();
        die("Error al procesar el pago: " . $e->getMessage());
    }
} else {
    die("Método no permitido.");
}
?>

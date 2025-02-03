<?php
require '../database/db.php';

if (isset($_GET['credito_id'])) {
    $credito_id = $_GET['credito_id'];

    // Consulta para obtener los detalles del crédito y su historial de pagos
    $sql = "SELECT 
                c.importe, 
                c.abono, 
                c.saldo_pendiente, 
                c.estado, 
                p.fecha_pago, 
                p.monto, 
                p.metodo_pago
            FROM creditos c
            LEFT JOIN pagos p ON c.id = p.credito_id
            WHERE c.id = :credito_id
            ORDER BY p.fecha_pago DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':credito_id', $credito_id, PDO::PARAM_INT);
    $stmt->execute();
    $pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificamos si hay registros en la consulta
    if (count($pagos) > 0) {
        // Información del crédito
        echo '<div class="mb-3">
                <h5>Información del Crédito</h5>
                <ul>
                    <li><strong>Importe Total:</strong> $' . number_format($pagos[0]['importe'], 2) . '</li>
                    <li><strong>Abonado:</strong> $' . number_format($pagos[0]['abono'], 2) . '</li>
                    <li><strong>Saldo Pendiente:</strong> $' . number_format($pagos[0]['saldo_pendiente'], 2) . '</li>
                    <li><strong>Estado:</strong> ' . ucfirst($pagos[0]['estado']) . '</li>
                </ul>
              </div>';

        echo '<h5>Historial de Pagos</h5>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha de Pago</th>
                        <th>Monto</th>
                        <th>Método de Pago</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($pagos as $pago) {
            // Solo imprimimos pagos si tienen fecha, evitando registros NULL
            if ($pago['fecha_pago']) {
                echo '<tr>
                        <td>' . date('d/m/Y', strtotime($pago['fecha_pago'])) . '</td>
                        <td>$' . number_format($pago['monto'], 2) . '</td>
                        <td>' . htmlspecialchars($pago['metodo_pago']) . '</td>
                      </tr>';
            }
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="text-center">No hay pagos registrados para este crédito.</p>';
    }
} else {
    echo '<p class="text-center text-danger">Error: Falta el ID del crédito.</p>';
}
?>

<?php
// Incluir la conexión a la base de datos
include '../database/db.php';

// Verificar si se pasó un ID de crédito
if (!isset($_GET['credito_id'])) {
    die("Crédito no especificado.");
}

$credito_id = $_GET['credito_id'];

try {
    // Consulta para obtener el historial de pagos de un crédito
    $query = "SELECT p.monto, p.fecha_pago, p.metodo_pago
              FROM pagos p
              WHERE p.credito_id = :credito_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['credito_id' => $credito_id]);

    // Verificar si la consulta retorna resultados
    if ($stmt->rowCount() > 0) {
        // Inicializar el contenido de la tabla de pagos
        $pagosRows = '';
        while ($pago = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pagosRows .= '
            <tr>
                <td>$' . number_format($pago['monto'], 2) . '</td>
                <td>' . date('d/m/Y', strtotime($pago['fecha_pago'])) . '</td>
                <td>' . htmlspecialchars($pago['metodo_pago']) . '</td>
            </tr>';
        }
    } else {
        $pagosRows = '<tr><td colspan="3" class="text-center">No se han registrado pagos para este crédito.</td></tr>';
    }
} catch (PDOException $e) {
    die("Error al obtener los pagos: " . $e->getMessage());
}

// El contenido de la página
$pageTitle = "Historial de Pagos";
$content = '
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history"></i> Historial de Pagos del Crédito</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Monto</th>
                            <th>Fecha de Pago</th>
                            <th>Metodo de Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $pagosRows . '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                 <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistrarPago">
                    <i class="fas fa-dollar-sign"></i> Registrar Pago
                </button>
';

// Modal para Registrar Pago
$content .= '
<div class="modal fade" id="modalRegistrarPago" tabindex="-1" aria-labelledby="modalRegistrarPagoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarPagoLabel">Registrar Pago del Crédito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Registro de Pago -->
                <form action="../models/procesar_pago.php" method="POST">
                    <input type="hidden" name="credito_id" value="' . $credito_id . '">
                    <div class="mb-3">
                        <label for="monto_pago" class="form-label">Monto del Pago</label>
                        <input type="number" class="form-control" id="monto_pago" name="monto_pago" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                    </div>
                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';

include '../templates/dashboard_layout.php';
?>

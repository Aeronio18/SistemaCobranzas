<?php
session_start();
require '../database/db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

$nombre_usuario = $_SESSION['username'];

// Obtener el ID del asesor basado en el nombre de usuario
$sqlAsesor = "SELECT id FROM asesores WHERE CONCAT(LEFT(nombre, 1), numero_asesor) = :nombre_usuario";
$stmtAsesor = $pdo->prepare($sqlAsesor);
$stmtAsesor->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
$stmtAsesor->execute();
$asesor = $stmtAsesor->fetch(PDO::FETCH_ASSOC);

if (!$asesor) {
    echo "<p class='text-danger'>No se encontró un asesor asociado a este usuario.</p>";
    exit();
}

$asesor_id = $asesor['id'];

// Consulta SQL para obtener los créditos asignados al asesor autenticado
$sql = "SELECT c.id, cl.nombre AS cliente, c.importe, c.fecha_inicio, c.fecha_termino, c.estado
        FROM creditos c
        INNER JOIN clientes cl ON c.cliente_id = cl.id
        WHERE c.asesor_id = :asesor_id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':asesor_id', $asesor_id, PDO::PARAM_INT);
$stmt->execute();
$creditos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Créditos Asignados";
$content = ' 
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Listado de Créditos Asignados</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Monto Prestado</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Término</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>';

if (!empty($creditos)) {
    foreach ($creditos as $credito) {
        $estado = htmlspecialchars($credito['estado']); // Estado del crédito
        $content .= ' 
        <tr>
            <td>' . htmlspecialchars($credito['cliente']) . '</td>
            <td>$' . number_format($credito['importe'], 2) . '</td>
            <td>' . date('d/m/Y', strtotime($credito['fecha_inicio'])) . '</td>
            <td>' . date('d/m/Y', strtotime($credito['fecha_termino'])) . '</td>
            <td>' . $estado . '</td>
            <td>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorialPago" onclick="cargarHistorial(' . $credito['id'] . ')">
                    <i class="fas fa-eye"></i> Ver Historial
                </button>';
                
                // Mostrar el botón "Registrar Pago" solo si el estado NO es "Pagado"
                if ($estado !== 'pagado') {
                    $content .= '
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarPago" onclick="setCreditoId(' . $credito['id'] . ')">
                        <i class="fas fa-dollar-sign"></i> Registrar Pago
                    </button>';
                }
                
        $content .= '  
            </td>
        </tr>';
    }
} else {
    $content .= '<tr><td colspan="6" class="text-center">No hay créditos asignados.</td></tr>';
}

$content .= ' 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para ver historial de pagos -->
<div class="modal fade" id="modalHistorialPago" tabindex="-1" aria-labelledby="modalHistorialPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHistorialPagoLabel">Historial de Pagos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="contenidoHistorial">
                    <!-- Aquí se cargará el historial de pagos dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Registrar Pago -->
<div class="modal fade" id="modalRegistrarPago" tabindex="-1" aria-labelledby="modalRegistrarPagoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarPagoLabel">Registrar Pago del Crédito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="../models/procesar_pago.php" method="POST">
                    <input type="hidden" name="credito_id" id="credito_id" value="">
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
</div>

<script>
function cargarHistorial(creditoId) {
    fetch("../controllers/obtener_historial.php?credito_id=" + creditoId)
        .then(response => response.text())
        .then(data => {
            document.getElementById("contenidoHistorial").innerHTML = data;
        })
        .catch(error => console.error("Error:", error));
}

function setCreditoId(creditoId) {
    document.getElementById("credito_id").value = creditoId;
}
</script>
';

include '../templates/dashboard_layout.php';
?>

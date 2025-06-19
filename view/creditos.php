<?php
include '../database/db.php';
session_start();
$role = $_SESSION['role'] ?? 'admin';
$filtro = $_GET['filtro'] ?? '';

// Consulta base
$queryBase = "SELECT c.id AS credito_id, cl.nombre AS cliente_nombre, c.importe, c.abono, c.saldo_pendiente, c.estado, c.fecha_inicio, c.fecha_termino, a.nombre AS asesor_nombre
              FROM creditos c
              JOIN clientes cl ON c.cliente_id = cl.id
              LEFT JOIN asesores a ON c.asesor_id = a.id";

// Aplicar filtro
switch ($filtro) {
    case 'pendiente':
        $queryBase .= " WHERE c.estado = 'pendiente'";
        break;
    case 'finalizado':
        $queryBase .= " WHERE c.estado = 'pagado'";
        break;
    case 'todos':
    default:
        // Sin filtro
        break;
}

try {
    $stmt = $pdo->query($queryBase);
    $creditosRows = '';
    $hayVencidos = false;

    while ($credito = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $esVencido = ($credito['estado'] === 'pendiente' && strtotime($credito['fecha_termino']) < time());
        $filaClase = $esVencido ? 'table-danger' : '';
        $estadoLabel = htmlspecialchars($credito['estado']);

        if ($esVencido) {
            $estadoLabel .= ' <span class="badge bg-danger" title="Crédito vencido">Vencido</span>';
            $hayVencidos = true;
        }

        $creditosRows .= '
        <tr class="' . $filaClase . '">
            <td>' . htmlspecialchars($credito['cliente_nombre']) . '</td>
            <td>$' . number_format($credito['importe'], 2) . '</td>
            <td>' . date('d/m/Y', strtotime($credito['fecha_inicio'])) . '</td>
            <td>' . date('d/m/Y', strtotime($credito['fecha_termino'])) . '</td>
            <td>' . $estadoLabel . '</td>
            <td>$' . number_format($credito['saldo_pendiente'], 2) . '</td>
            <td>' . htmlspecialchars($credito['asesor_nombre']) . '</td>
            <td>
                <a href="historial_pagos.php?credito_id=' . $credito['credito_id'] . '" class="btn btn-info btn-sm" title="Ver Historial de Pagos">
                    <i class="fas fa-history"></i>
                </a>
            </td>
        </tr>';
    }

    if (empty($creditosRows)) {
        $creditosRows = '<tr><td colspan="8" class="text-center">No se encontraron créditos registrados.</td></tr>';
    }

    // Totales
    $creditosTotalesCount = $pdo->query("SELECT COUNT(*) AS count FROM creditos")->fetch(PDO::FETCH_ASSOC)['count'];
    $creditosPendientesCount = $pdo->query("SELECT COUNT(*) AS count FROM creditos WHERE estado = 'pendiente'")->fetch(PDO::FETCH_ASSOC)['count'];
    $creditosFinalizadosCount = $pdo->query("SELECT COUNT(*) AS count FROM creditos WHERE estado = 'pagado'")->fetch(PDO::FETCH_ASSOC)['count'];

} catch (PDOException $e) {
    die("Error al obtener los créditos: " . $e->getMessage());
}
?>

<?php ob_start(); ?>
<div class="row g-4">
    <?php if ($role !== 'asist'): ?>
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                    <h5 class="card-title">Renovacion de creditos</h5>
                    <p class="card-text">Renovar crédito.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="registrar_credito.php" class="btn btn-light btn-sm w-100">
                        <i class="fas fa-plus-circle"></i> Registrar
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="col-md-3 col-sm-6">
        <a href="?filtro=todos" class="text-decoration-none">
            <div class="card text-bg-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-coins fa-3x mb-3"></i>
                    <h5 class="card-title">Todos los Créditos</h5>
                    <p class="card-text"><?= $creditosTotalesCount ?> créditos registrados</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 col-sm-6">
        <a href="?filtro=pendiente" class="text-decoration-none">
            <div class="card text-bg-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-hourglass-half fa-3x mb-3"></i>
                    <h5 class="card-title">Créditos Pendientes</h5>
                    <p class="card-text"><?= $creditosPendientesCount ?> créditos pendientes</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 col-sm-6">
        <a href="?filtro=finalizado" class="text-decoration-none">
            <div class="card text-bg-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h5 class="card-title">Créditos Finalizados</h5>
                    <p class="card-text"><?= $creditosFinalizadosCount ?> créditos completados</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Tabla de créditos -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-table"></i> Listado de Créditos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Cantidad Solicitada</th>
                            <th>Fecha Solicitada</th>
                            <th>Fecha Vencimiento</th>
                            <th>Estado</th>
                            <th>Saldo Pendiente</th>
                            <th>Asesor</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody><?= $creditosRows ?></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if ($hayVencidos): ?>
<!-- Toast de alerta -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="vencidoToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Atención: Existen créditos vencidos.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('vencidoToast');
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
$pageTitle = "Créditos";
include '../templates/dashboard_layout.php';
?>

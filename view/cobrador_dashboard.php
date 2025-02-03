<?php
session_start();
$pageTitle = "Dashboard Cobrador";
$nombre_usuario = $_SESSION['username'];

// Conexión a la base de datos
require_once '../database/db.php';

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
// Obtener la fecha de hoy
$hoy = date('Y-m-d');

// Consultas combinadas para obtener los créditos pendientes y los pagos realizados hoy
$queryCreditos = "
    SELECT c.id, cl.nombre, cl.direccion, cl.ubicacion_google_maps, c.importe, c.abono, c.estado, 
           COUNT(p.credito_id) AS pagos_realizados
    FROM creditos c
    JOIN clientes cl ON c.cliente_id = cl.id
    LEFT JOIN pagos p ON c.id = p.credito_id AND DATE(p.fecha_pago) = :hoy
    WHERE c.asesor_id = :asesor_id 
    AND c.estado != 'pagado' 
    AND (p.credito_id IS NULL OR DATE(p.fecha_pago) != :hoy)  -- Excluir pagos realizados hoy
    GROUP BY c.id, cl.nombre, cl.direccion, cl.ubicacion_google_maps, c.importe, c.abono, c.estado";
$stmtCreditos = $pdo->prepare($queryCreditos);
$stmtCreditos->bindParam(':hoy', $hoy);
$stmtCreditos->bindParam(':asesor_id', $asesor_id, PDO::PARAM_INT);
$stmtCreditos->execute();

// Consultas para contar los créditos pagados hoy y el total de créditos
$queryCreditosPagadosHoy = "SELECT COUNT(*) FROM pagos p
                             JOIN creditos c ON p.credito_id = c.id
                             WHERE DATE(p.fecha_pago) = :hoy AND c.asesor_id = :asesor_id";
$stmtCreditosPagadosHoy = $pdo->prepare($queryCreditosPagadosHoy);
$stmtCreditosPagadosHoy->bindParam(':hoy', $hoy);
$stmtCreditosPagadosHoy->bindParam(':asesor_id', $asesor_id, PDO::PARAM_INT);
$stmtCreditosPagadosHoy->execute();
$creditosPagadosHoy = $stmtCreditosPagadosHoy->fetchColumn();

// Obtener el total de créditos para calcular el porcentaje de avance
$queryTotalCreditos = "SELECT COUNT(*) FROM creditos c WHERE c.asesor_id = :asesor_id AND c.estado != 'pagado'";
$stmtTotalCreditos = $pdo->prepare($queryTotalCreditos);
$stmtTotalCreditos->bindParam(':asesor_id', $asesor_id, PDO::PARAM_INT);
$stmtTotalCreditos->execute();
$totalCreditos = $stmtTotalCreditos->fetchColumn();

// Calcular el porcentaje de avance
$porcentajeAvance = ($totalCreditos > 0) ? min(($creditosPagadosHoy / $totalCreditos) * 100, 100) : 0;

// Comenzamos a construir el contenido
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Row 1: Tarjetas -->
        <div class="row">
            <!-- Pagos -->
            <div class="col-lg-6 col-12">
                <div class="card card-primary h-100">
                    <div class="card-header">
                        <h3 class="card-title">Creditos</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                        <p>Consulta y gestiona los creditos asignados.</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="pagos.php" class="btn btn-outline-primary"><i class="fas fa-eye"></i> Ver</a>
                    </div>
                </div>
            </div>

            <!-- Avance de pagos -->
            <div class="col-lg-6 col-12">
                <div class="card card-success h-100">
                    <div class="card-header">
                        <h3 class="card-title">Avance de Pagos</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                        <h4>' . number_format($porcentajeAvance, 2) . '%</h4>
                        <p>Porcentaje de créditos pagados hoy.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de la ruta del día -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Resumen de la Ruta del Día - ' . date('d/m/Y') . '</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Dirección</th>
                                    <th>Saldo Pendiente</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>';

                            // Llenamos la tabla con los datos obtenidos de los créditos no pagados hoy
                            while ($row = $stmtCreditos->fetch(PDO::FETCH_ASSOC)) {
                                $montoPagar = $row['importe'] - $row['abono'];
                                
                                if ($montoPagar > 0) {
                                    $estadoBadge = ($row['estado'] == 'pendiente') ? 'bg-warning' : 'bg-success';
                                    $estadoText = ($row['estado'] == 'pendiente') ? 'Pendiente' : 'Pagado';
                                    $content .= '
                                    <tr>
                                        <td>' . htmlspecialchars($row['nombre']) . '</td>
                                        <td>' . htmlspecialchars($row['direccion']) . '
                                            <a href="' . htmlspecialchars($row['ubicacion_google_maps']) . '" class="btn btn-sm" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Mapa">
                                                <i class="fas fa-map-marker-alt text-info"></i>
                                            </a>
                                        </td>
                                        <td>$' . number_format($montoPagar, 2) . '</td>
                                        <td><span class="badge ' . $estadoBadge . '">' . $estadoText . '</span></td>
                                    </tr>';
                                }
                            }

                            $content .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>';

include '../templates/dashboard_layout.php';
?>

<?php
$pageTitle = "Dashboard Cobrador";

// Conexión a la base de datos
require_once '../database/db.php';

// Obtener la fecha de hoy
$hoy = date('Y-m-d');

// Consulta para obtener los créditos pendientes, excluyendo los pagados hoy
$queryCreditos = "SELECT c.id, cl.nombre, cl.direccion, c.importe, c.abono, c.estado
                  FROM creditos c
                  JOIN clientes cl ON c.cliente_id = cl.id
                  LEFT JOIN pagos p ON c.id = p.credito_id AND DATE(p.fecha_pago) = :hoy
                  WHERE c.estado != 'pagado' AND p.credito_id IS NULL";  // Excluye los créditos con pagos registrados hoy
$stmtCreditos = $pdo->prepare($queryCreditos);
$stmtCreditos->bindParam(':hoy', $hoy);
$stmtCreditos->execute();

// Consulta para contar los créditos pagados hoy
$queryCreditosPagadosHoy = "SELECT COUNT(*) FROM pagos p
                             JOIN creditos c ON p.credito_id = c.id
                             WHERE DATE(p.fecha_pago) = :hoy";
$stmtCreditosPagadosHoy = $pdo->prepare($queryCreditosPagadosHoy);
$stmtCreditosPagadosHoy->bindParam(':hoy', $hoy);
$stmtCreditosPagadosHoy->execute();
$creditosPagadosHoy = $stmtCreditosPagadosHoy->fetchColumn();

// Obtener el total de créditos para calcular el porcentaje de avance
$queryTotalCreditos = "SELECT COUNT(*) FROM creditos c WHERE c.estado != 'pagado'";
$stmtTotalCreditos = $pdo->prepare($queryTotalCreditos);
$stmtTotalCreditos->execute();
$totalCreditos = $stmtTotalCreditos->fetchColumn();

// Calcular el porcentaje de avance
$porcentajeAvance = ($totalCreditos > 0) ? ($creditosPagadosHoy / $totalCreditos) * 100 : 0;

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
                                    <th>Monto a Pagar</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>';

                            // Llenamos la tabla con los datos obtenidos de los créditos no pagados hoy
                            while ($row = $stmtCreditos->fetch(PDO::FETCH_ASSOC)) {
                                $montoPagar = $row['importe'] - $row['abono'];
                                
                                // Solo mostrar los créditos que no han sido pagados hoy y tienen un monto mayor a 0
                                if ($montoPagar > 0) {
                                    $estadoBadge = ($row['estado'] == 'pendiente') ? 'bg-warning' : 'bg-success';
                                    $estadoText = ($row['estado'] == 'pendiente') ? 'Pendiente' : 'Pagado';
                                    $content .= '
                                    <tr>
                                        <td>' . htmlspecialchars($row['nombre']) . '</td>
                                        <td>' . htmlspecialchars($row['direccion']) . '</td>
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


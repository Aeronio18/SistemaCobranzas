<?php
$pageTitle = "Dashboard Admin";

// Conexión a la base de datos
require_once '../database/db.php';
// Obtener el total de créditos pagados hoy
$queryCreditosPagadosHoy = "
SELECT COUNT(*) AS pagos_totales
FROM pagos p
INNER JOIN creditos c ON p.credito_id = c.id
WHERE c.estado = 'pagado' AND DATE(p.fecha_pago) = CURDATE()
";
$resultCreditosPagadosHoy = $pdo->query($queryCreditosPagadosHoy);
$totalCreditosPagadosHoy = $resultCreditosPagadosHoy->fetch(PDO::FETCH_ASSOC)['pagos_totales'];

// Obtener el total de créditos pendientes para calcular el porcentaje
$queryCreditosPendientes = "SELECT COUNT(*) AS total FROM creditos WHERE estado = 'pendiente'";
$resultCreditosPendientes = $pdo->query($queryCreditosPendientes);
$totalCreditosPendientes = $resultCreditosPendientes->fetch(PDO::FETCH_ASSOC)['total'];

// Calcular el porcentaje de créditos pagados hoy
$totalCreditos = $totalCreditosPagadosHoy + $totalCreditosPendientes;
$porcentajePagadosHoy = ($totalCreditos > 0) ? ($totalCreditosPagadosHoy / $totalCreditos) * 100 : 0;

// Obtener el número de asesores activos
$queryAsesores = "SELECT COUNT(*) AS total FROM asesores WHERE estado = 'activo'";
$resultAsesores = $pdo->query($queryAsesores);
$totalAsesores = $resultAsesores->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener el número de créditos por cobrar
$queryCreditos = "SELECT COUNT(*) AS total FROM creditos WHERE estado = 'pendiente'";
$resultCreditos = $pdo->query($queryCreditos);
$totalCreditos = $resultCreditos->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener el número de clientes registrados
$queryClientes = "SELECT COUNT(*) AS total FROM clientes";
$resultClientes = $pdo->query($queryClientes);
$totalClientes = $resultClientes->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener los asesores con créditos por cobrar
$queryAsesoresCreditos = "
    SELECT a.nombre,a.estado, COUNT(c.id) AS creditos_por_cobrar
    FROM asesores a
    LEFT JOIN creditos c ON a.id = c.asesor_id
    WHERE c.estado = 'pendiente'
    GROUP BY a.id
";
$resultAsesoresCreditos = $pdo->query($queryAsesoresCreditos);

// Consultas para los gráficos: Créditos pagados por día
$queryCreditosPagadosPorDia = "
SELECT COUNT(p.id) AS pagos_totales, DATE(p.fecha_pago) AS fecha
FROM pagos p
INNER JOIN creditos c ON p.credito_id = c.id
WHERE c.estado = 'pagado'
GROUP BY DATE(p.fecha_pago)
";
$resultCreditosPagadosPorDia = $pdo->query($queryCreditosPagadosPorDia);

// Consultas para los gráficos: Créditos cobrados por asesor por día
$queryCreditosCobradosPorAsesor = "
SELECT a.nombre, COUNT(c.id) AS creditos_cobrados, DATE(p.fecha_pago) AS fecha
FROM pagos p
INNER JOIN creditos c ON p.credito_id = c.id
INNER JOIN asesores a ON c.asesor_id = a.id
WHERE c.estado = 'pagado'
GROUP BY a.id, DATE(p.fecha_pago)
";
$resultCreditosCobradosPorAsesor = $pdo->query($queryCreditosCobradosPorAsesor);
// Consulta para obtener el avance de cada asesor, incluyendo el estado
$queryAvanceRutas = "
SELECT a.nombre, a.estado, COUNT(c.id) AS total_creditos, SUM(IF(p.credito_id IS NOT NULL, 1, 0)) AS total_cobrados
FROM asesores a
LEFT JOIN creditos c ON a.id = c.asesor_id
LEFT JOIN pagos p ON c.id = p.credito_id AND p.fecha_pago IS NOT NULL
WHERE a.estado = 'activo'  -- Solo asesores activos
GROUP BY a.id
";
$stmtAvanceRutas = $pdo->query($queryAvanceRutas);

// Obtener los datos para los gráficos
$pagosPorDiaLabels = [];
$pagosPorDiaData = [];
while ($row = $resultCreditosPagadosPorDia->fetch(PDO::FETCH_ASSOC)) {
    $pagosPorDiaLabels[] = $row['fecha'];
    $pagosPorDiaData[] = $row['pagos_totales'];
}

$asesoresCobradosLabels = [];
$asesoresCobradosData = [];
while ($row = $resultCreditosCobradosPorAsesor->fetch(PDO::FETCH_ASSOC)) {
    $asesoresCobradosLabels[] = $row['nombre'] . ' (' . $row['fecha'] . ')';
    $asesoresCobradosData[] = $row['creditos_cobrados'];
}

// Contenido dinámico para el dashboard
$content = '
<div class="row g-4">
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-primary h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x mb-4"></i>
                <h5 class="card-title">Asesores</h5>
                <p class="card-text">Gestión de todos los asesores.</p>
                <h5>' . $totalAsesores . '</h5>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="cobradores.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-success h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-wallet fa-3x mb-4"></i>
                <h5 class="card-title">Créditos</h5>
                <p class="card-text">Consulta los créditos otorgados.</p>
                <h5>' . $totalCreditos . '</h5>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="creditos.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
   <div class="col-md-3 col-sm-6">
        <div class="card text-bg-warning h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-route fa-3x mb-4"></i>
                <h5 class="card-title">Rutas</h5>
                <p class="card-text">Avance de las rutas por asesor.</p>
                <h5>' . number_format($porcentajePagadosHoy, 2) . '% Créditos Pagados Hoy</h5>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="route.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-info h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x mb-4"></i>
                <h5 class="card-title">Clientes</h5>
                <p class="card-text">Gestiona los clientes registrados.</p>
                <h5>' . $totalClientes . '</h5>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="clientes.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
</div>

<!-- Resumen debajo de las tarjetas -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Asesores Activos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Asesor</th>
                            <th>Créditos por Cobrar</th>
                        </tr>
                    </thead>
                    <tbody>';
                    while ($asesor = $resultAsesoresCreditos->fetch(PDO::FETCH_ASSOC)) {
                        if ($asesor['estado'] !== 'activo') {
                            continue; // Saltar al siguiente asesor si no está activo
                        }
                        $content .= '<tr>
                            <td>' . htmlspecialchars($asesor['nombre']) . '</td>
                            <td>' . $asesor['creditos_por_cobrar'] . '</td>
                        </tr>';
                    }
$content .= '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Créditos -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Créditos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Crédito Actual</th>
                            <th>Fecha Limite</th>
                        </tr>
                    </thead>
                    <tbody>';

                    // Obtener los créditos y mostrarlos
                    $queryCreditosLista = "
                        SELECT cl.nombre, c.importe, c.fecha_termino 
                        FROM creditos c
                        JOIN clientes cl ON c.cliente_id = cl.id
                        WHERE c.estado = 'pendiente'
                    ";
                    $resultCreditosLista = $pdo->query($queryCreditosLista);
                    while ($credito = $resultCreditosLista->fetch(PDO::FETCH_ASSOC)) {
                        $content .= '<tr>
                            <td>' . htmlspecialchars($credito['nombre']) . '</td>
                            <td>' . number_format($credito['importe'], 2) . '</td>
                            <td>' . htmlspecialchars($credito['fecha_termino']) . '</td>
                        </tr>';
                    }

$content .= '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   <!-- Avance de Asesores -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Avance de Asesores - ' . date('d/m/Y') . '</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Asesor</th>
                            <th>Créditos Asignados</th>
                            <th>Total Cobrados</th>
                            <th>Avance</th>
                        </tr>
                    </thead>
                    <tbody>';

                    while ($row = $stmtAvanceRutas->fetch(PDO::FETCH_ASSOC)) {
                        // Filtrar solo asesores activos
                        if ($row['estado'] !== 'activo') {
                            continue; // Saltar al siguiente asesor si no está activo
                        }

                        $totalCreditos = $row['total_creditos'];
                        $totalCobrados = $row['total_cobrados'] ?: 0; // Si no hay pagos, usamos 0
                        $avancePorcentaje = ($totalCreditos > 0) ? ($totalCobrados / $totalCreditos) * 100 : 0;

                        $content .= '
                        <tr>
                            <td>' . htmlspecialchars($row['nombre']) . '</td>
                            <td>' . $totalCreditos . '</td>
                            <td>' . number_format($totalCobrados, 2) . '</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: ' . $avancePorcentaje . '%" aria-valuenow="' . $avancePorcentaje . '" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>';
                    }

$content .= '
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Gráficas -->
<div class="row mt-4">
    <!-- Gráfica de Créditos Pagados por Día -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Créditos Pagados por Día</h5>
            </div>
            <div class="card-body">
                <canvas id="pagosPorDiaChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Gráfica de Créditos Cobrados por Asesor por Día -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Créditos Cobrados por Asesor por Día</h5>
            </div>
            <div class="card-body">
                <canvas id="cobradosPorAsesorChart"></canvas>
            </div>
        </div>
    </div>
</div>';

include '../templates/dashboard_layout.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Créditos Pagados por Día
    var ctx1 = document.getElementById("pagosPorDiaChart").getContext("2d");
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: <?php echo json_encode($pagosPorDiaLabels); ?>,
            datasets: [{
                label: "Créditos Pagados",
                data: <?php echo json_encode($pagosPorDiaData); ?>,
                borderColor: "#28a745",
                fill: false
            }]
        }
    });

    // Gráfico de Créditos Cobrados por Asesor por Día
    var ctx2 = document.getElementById("cobradosPorAsesorChart").getContext("2d");
    new Chart(ctx2, {
        type: "bar",
        data: {
            labels: <?php echo json_encode($asesoresCobradosLabels); ?>,
            datasets: [{
                label: "Créditos Cobrados",
                data: <?php echo json_encode($asesoresCobradosData); ?>,
                backgroundColor: "#007bff"
            }]
        }
    });
</script>

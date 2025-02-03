<?php
$pageTitle = "Avance de Rutas del Día";

// Conexión a la base de datos
require_once '../database/db.php';

// Obtener la fecha de hoy
$hoy = date('Y-m-d');

// Consultar el total de clientes
$queryTotalClientes = "SELECT COUNT(*) FROM clientes";
$stmtTotalClientes = $pdo->prepare($queryTotalClientes);
$stmtTotalClientes->execute();
$totalClientes = $stmtTotalClientes->fetchColumn();

// Consultar los clientes atendidos
$queryClientesAtendidos = "SELECT COUNT(*) FROM creditos c
                           JOIN pagos p ON c.id = p.credito_id
                           WHERE DATE(p.fecha_pago) = :hoy";
$stmtClientesAtendidos = $pdo->prepare($queryClientesAtendidos);
$stmtClientesAtendidos->bindParam(':hoy', $hoy);
$stmtClientesAtendidos->execute();
$clientesAtendidos = $stmtClientesAtendidos->fetchColumn();

// Consultar los clientes restantes
$clientesRestantes = $totalClientes - $clientesAtendidos;

// Obtener el avance por asesor basado en los créditos y pagos
$queryAvanceRutas = "
    SELECT a.id, a.nombre,
           (SELECT COUNT(*) FROM creditos c WHERE c.asesor_id = a.id) AS total_creditos,
           (SELECT COUNT(*) FROM pagos p
            JOIN creditos c ON p.credito_id = c.id
            WHERE c.asesor_id = a.id AND DATE(p.fecha_pago) = :hoy) AS total_cobrados
    FROM asesores a
    WHERE a.estado = 'activo'  -- Filtrar solo los asesores activos
";
$stmtAvanceRutas = $pdo->prepare($queryAvanceRutas);
$stmtAvanceRutas->bindParam(':hoy', $hoy);
$stmtAvanceRutas->execute();

// Comenzamos a construir el contenido
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Avance General de las Rutas -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Avance General de las Rutas del Día - ' . date('d/m/Y') . '</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <!-- Progress bar circular usando ProgressBar.js -->
                        <div class="text-center" style="margin-right: 30px;">
                            <div id="progress-circle" style="width: 100px; height: 100px;"></div>
                        </div>
                        <div class="ml-4">
                            <p><strong>Total Clientes:</strong> ' . $totalClientes . '</p>
                            <p><strong>Clientes Atendidos:</strong> ' . $clientesAtendidos . '</p>
                            <p><strong>Clientes Restantes:</strong> ' . $clientesRestantes . '</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Avance Individual por Asesor -->
        <div class="row">
            <div class="col-12">
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

                            // Llenamos la tabla con los datos de los asesores
                            while ($row = $stmtAvanceRutas->fetch(PDO::FETCH_ASSOC)) {
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
    </div>
</section>';

include '../templates/dashboard_layout.php';
?>
<!-- Incluir ProgressBar.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>
<!-- Script para ProgressBar.js -->
<script>
    // Calcular el porcentaje de clientes atendidos
    var totalClientes = <?php echo $totalClientes; ?>;
    var clientesAtendidos = <?php echo $clientesAtendidos; ?>;
    var porcentajeAvance = (totalClientes > 0) ? (clientesAtendidos / totalClientes) * 100 : 0;

    // Crear la barra de progreso circular usando ProgressBar.js
    var progress = new ProgressBar.Circle('#progress-circle', {
        strokeWidth: 10,  // Mantener el grosor de la barra
        color: '#4caf50',
        trailColor: '#eee',
        trailWidth: 2,
        duration: 1400,
        easing: 'easeInOut',
        text: {
            style: {
                fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif',
                fontSize: '1.5rem',  // Ajustar el tamaño del texto
                fontWeight: 'bold',
                color: '#4caf50',
            },
            autoStyleContainer: false,
            position: 'center',
            value: porcentajeAvance.toFixed(0) + '%', // Mostrar el porcentaje calculado
        },
        from: { color: '#eee', width: 1 },
        to: { color: '#4caf50', width: 10 },
    });

    // Iniciar la animación con el porcentaje dinámico
    progress.animate(porcentajeAvance / 100);  // Avance basado en el porcentaje calculado
</script>

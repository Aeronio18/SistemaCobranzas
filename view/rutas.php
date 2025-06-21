<?php
session_start();
require '../database/db.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

$nombre_usuario = $_SESSION['username'];
$hoy = date('Y-m-d');

// Obtener el ID del asesor basado en el nombre de usuario
$sqlAsesor = "SELECT id FROM asesores WHERE nombre_usuario = :nombre_usuario";
$stmtAsesor = $pdo->prepare($sqlAsesor);
$stmtAsesor->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
$stmtAsesor->execute();
$asesor = $stmtAsesor->fetch(PDO::FETCH_ASSOC);

if (!$asesor) {
    echo "<p class='text-danger'>No se encontró un asesor asociado a este usuario.</p>";
    exit();
}

$asesor_id = $asesor['id'];

// Consultas combinadas para obtener los créditos pendientes y el conteo de pagos realizados hoy
$query = "
    SELECT c.id, cl.nombre, cl.direccion, cl.ubicacion_google_maps, c.importe, c.abono, c.estado,
           COUNT(p.credito_id) AS pagos_realizados
    FROM creditos c
    JOIN clientes cl ON c.cliente_id = cl.id
    LEFT JOIN pagos p ON c.id = p.credito_id AND DATE(p.fecha_pago) = :hoy
    WHERE c.asesor_id = :asesor_id AND c.estado != 'pagado'
    GROUP BY c.id, cl.nombre, cl.direccion, cl.ubicacion_google_maps, c.importe, c.abono, c.estado
    HAVING COUNT(p.credito_id) = 0
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':hoy', $hoy);
$stmt->bindParam(':asesor_id', $asesor_id, PDO::PARAM_INT);
$stmt->execute();

// Consultar el total de créditos pagados hoy
$queryCreditosPagadosHoy = "
    SELECT COUNT(*) FROM pagos p
    JOIN creditos c ON p.credito_id = c.id
    WHERE DATE(p.fecha_pago) = :hoy AND c.asesor_id = :asesor_id
";
$stmtCreditosPagadosHoy = $pdo->prepare($queryCreditosPagadosHoy);
$stmtCreditosPagadosHoy->bindParam(':hoy', $hoy);
$stmtCreditosPagadosHoy->bindParam(':asesor_id', $asesor_id, PDO::PARAM_INT);
$stmtCreditosPagadosHoy->execute();
$creditosPagadosHoy = $stmtCreditosPagadosHoy->fetchColumn();

// Construir el contenido
$pageTitle = "Avance de Rutas del Día";
$content = '
<section class="content">
    <div class="container-fluid">
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

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

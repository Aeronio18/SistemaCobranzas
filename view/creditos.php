<?php
// Incluir la conexión a la base de datos
include '../database/db.php';

// Obtener el rol del usuario desde la sesión
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'admin'; // Asignar un rol predeterminado

try {
    // Consulta para obtener los créditos con los datos del cliente y asesor
    $query = "SELECT c.id AS credito_id, cl.nombre AS cliente_nombre, c.importe, c.abono, c.saldo_pendiente, c.estado, c.fecha_inicio, c.fecha_termino, a.nombre AS asesor_nombre
              FROM creditos c
              JOIN clientes cl ON c.cliente_id = cl.id
              LEFT JOIN asesores a ON c.asesor_id = a.id";  // Asegúrate de tener la tabla asesores y la columna asesor_id en la tabla creditos
    $stmt = $pdo->query($query);

    // Verificar si la consulta retorna resultados
    if ($stmt->rowCount() > 0) {
        // Inicializar el contenido de la tabla
        $creditosRows = '';
        while ($credito = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $creditosRows .= '
            <tr>
                <td>' . htmlspecialchars($credito['cliente_nombre']) . '</td>
                <td>$' . number_format($credito['importe'], 2) . '</td>
                <td>' . date('d/m/Y', strtotime($credito['fecha_inicio'])) . '</td>
                <td>' . date('d/m/Y', strtotime($credito['fecha_termino'])) . '</td>
                <td>' . htmlspecialchars($credito['estado']) . '</td>
                <td>$' . number_format($credito['saldo_pendiente'], 2) . '</td>
                <td>' . htmlspecialchars($credito['asesor_nombre']) . '</td> <!-- Mostrar el nombre del asesor -->
                <td>
                    <a href="historial_pagos.php?credito_id=' . $credito['credito_id'] . '" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Historial de Pagos">
                        <i class="fas fa-history"></i>
                    </a>
                </td>
            </tr>';
        }
    } else {
        $creditosRows = '<tr><td colspan="8" class="text-center">No se encontraron créditos registrados.</td></tr>';
    }

    // Consultas para los datos de las tarjetas
    $creditosActivosQuery = "SELECT COUNT(*) AS count FROM creditos WHERE estado = 'pendiente'";
    $creditosPendientesQuery = "SELECT COUNT(*) AS count FROM creditos WHERE fecha_termino < CURDATE() AND estado = 'pendiente'";
    $creditosFinalizadosQuery = "SELECT COUNT(*) AS count FROM creditos WHERE estado = 'pagado'";

    // Ejecutar las consultas para los totales
    $creditosActivosStmt = $pdo->query($creditosActivosQuery);
    $creditosPendientesStmt = $pdo->query($creditosPendientesQuery);
    $creditosFinalizadosStmt = $pdo->query($creditosFinalizadosQuery);

    $creditosActivosCount = $creditosActivosStmt->fetch(PDO::FETCH_ASSOC)['count'];
    $creditosPendientesCount = $creditosPendientesStmt->fetch(PDO::FETCH_ASSOC)['count'];
    $creditosFinalizadosCount = $creditosFinalizadosStmt->fetch(PDO::FETCH_ASSOC)['count'];

} catch (PDOException $e) {
    die("Error al obtener los créditos: " . $e->getMessage());
}

// El contenido de la página
$pageTitle = "Créditos";
$content = '<div class="row g-4">';

// Si el rol no es 'asist', mostrar la tarjeta de "Nuevo Crédito"
if ($role !== 'asist') {
    $content .= '
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-success h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                <h5 class="card-title">Nuevo Crédito</h5>
                <p class="card-text">Registrar un nuevo crédito.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="registrar_credito.php" class="btn btn-light btn-sm w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar un nuevo crédito">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>';
}

$content .= '
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-primary h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-coins fa-3x mb-3"></i>
                <h5 class="card-title">Créditos Actuales</h5>
                <p class="card-text">' . $creditosActivosCount . ' créditos activos</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-warning h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-hourglass-half fa-3x mb-3"></i>
                <h5 class="card-title">Créditos Pendientes</h5>
                <p class="card-text">' . $creditosPendientesCount . ' créditos pendientes hoy</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-secondary h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-3x mb-3"></i>
                <h5 class="card-title">Créditos Finalizados</h5>
                <p class="card-text">' . $creditosFinalizadosCount . ' créditos completados</p>
            </div>
        </div>
    </div>
</div>

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
                            <th>Asesor</th> <!-- Agregar columna para el asesor -->
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $creditosRows . '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>';

include '../templates/dashboard_layout.php';
?>

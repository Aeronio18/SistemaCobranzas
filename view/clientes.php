<?php
// Configuración de la página
$pageTitle = "Gestión de Clientes";

// Conexión a la base de datos
include '../database/db.php';

// Consulta para obtener la lista de clientes
$sql = "SELECT * FROM clientes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contenido de la página
$content = '
<div class="container">
    <div class="row g-4">
        <!-- Tarjeta para registrar nuevo cliente -->
        <div class="col-md-12">
            <div class="card text-bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Registrar Nuevo Cliente</h5>
                    <p class="card-text">Agrega un nuevo cliente al sistema.</p>
                    <a href="registrar_cliente.php" class="btn btn-light btn-sm">Registrar Cliente</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Lista de Clientes</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Giro del Negocio</th>
                                <th>Tipo de Producto</th>
                                <th>Foto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';

// Verifica si hay clientes en la base de datos
if (count($clientes) > 0) {
    foreach ($clientes as $cliente) {
        $content .= '
            <tr>
                <td>' . htmlspecialchars($cliente['nombre']) . '</td>
                <td>' . htmlspecialchars($cliente['direccion']) . '</td>
                <td>' . htmlspecialchars($cliente['telefono']) . '</td>
                <td>' . htmlspecialchars($cliente['giro_negocio']) . '</td>
                <td>' . htmlspecialchars($cliente['tipo_producto']) . '</td>
                <td>
                    <img src="../img/clientes/' . htmlspecialchars($cliente['foto_local']) . '" alt="Foto Local" width="50">
                </td>
                <td>
                    <a href="' . htmlspecialchars($cliente['ubicacion_google_maps']) . '" class="btn btn-info btn-sm" target="_blank">
                        <i class="fas fa-map-marker-alt"></i> Ver Mapa
                    </a>
                </td>
            </tr>';
    }
} else {
    $content .= '<tr><td colspan="7" class="text-center">No hay clientes registrados.</td></tr>';
}

$content .= '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>';

// Carga el layout principal
include '../templates/dashboard_layout.php';
?>

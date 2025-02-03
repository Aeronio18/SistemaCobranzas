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
                    <a href="' . htmlspecialchars($cliente['ubicacion_google_maps']) . '" class="btn btn-sm" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Mapa">
                        <i class="fas fa-map-marker-alt text-info"></i>
                    </a>
                    <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#clienteModal"
    data-nombre="' . htmlspecialchars($cliente['nombre']) . '"
    data-direccion="' . htmlspecialchars($cliente['direccion']) . '"
    data-telefono="' . htmlspecialchars($cliente['telefono']) . '"
    data-giro="' . htmlspecialchars($cliente['giro_negocio']) . '"
    data-producto="' . htmlspecialchars($cliente['tipo_producto']) . '"
    data-foto="../img/clientes/' . htmlspecialchars($cliente['foto_local']) . '"
    data-ubicacion="' . htmlspecialchars($cliente['ubicacion_google_maps']) . '"
    data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Información">
    <i class="fas fa-eye text-primary"></i>
</button>

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
</div>

<!-- Modal para mostrar información del cliente -->
<div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clienteModalLabel">Información del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="text-center"> <img id="modalFoto" src="" alt="Foto del Local" width="60%"></p>
                <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                <p><strong>Dirección:</strong> <span id="modalDireccion"></span></p>
                <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
                <p><strong>Giro del Negocio:</strong> <span id="modalGiro"></span></p>
                <p><strong>Tipo de Producto:</strong> <span id="modalProducto"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
';

// Carga el layout principal
include '../templates/dashboard_layout.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var clienteModal = document.getElementById("clienteModal");
    clienteModal.addEventListener("show.bs.modal", function(event) {
        var button = event.relatedTarget;
        
        document.getElementById("modalNombre").textContent = button.getAttribute("data-nombre");
        document.getElementById("modalDireccion").textContent = button.getAttribute("data-direccion");
        document.getElementById("modalTelefono").textContent = button.getAttribute("data-telefono");
        document.getElementById("modalGiro").textContent = button.getAttribute("data-giro");
        document.getElementById("modalProducto").textContent = button.getAttribute("data-producto");
        document.getElementById("modalFoto").src = button.getAttribute("data-foto");
    });
    
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
<?php
$pageTitle = "Pagos";
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Tarjetas Resumen -->
        <div class="row">
            <!-- Pagos Realizados del Día -->
            <div class="col-lg-4 col-12">
                <div class="card card-success h-100">
                    <div class="card-header">
                        <h3 class="card-title">Pagos Realizados</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h4>15</h4> <!-- Número de pagos realizados -->
                        <p>Pagos realizados en el día.</p>
                    </div>
                </div>
            </div>

            <!-- Pagos Pendientes -->
            <div class="col-lg-4 col-12">
                <div class="card card-warning h-100">
                    <div class="card-header">
                        <h3 class="card-title">Pagos Pendientes</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x mb-3"></i>
                        <h4>10</h4> <!-- Número de pagos pendientes -->
                        <p>Pagos aún pendientes de realizar.</p>
                    </div>
                </div>
            </div>

            <!-- Avance de la Ruta del Día -->
            <div class="col-lg-4 col-12">
                <div class="card card-info h-100">
                    <div class="card-header">
                        <h3 class="card-title">Avance de la Ruta</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-route fa-3x mb-3"></i>
                        <h4>75%</h4> <!-- Porcentaje de avance -->
                        <p>Porcentaje de avance en la ruta del día.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listado de Pagos -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Listado de Pagos</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Monto Prestado</th>
                                    <th>Plazo</th>
                                    <th>Fecha Último Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de un historial de pagos -->
                                <tr>
                                    <td>Cliente 1</td>
                                    <td>$5,000</td>
                                    <td>6 meses</td>
                                    <td>15/01/2025</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorialPago" onclick="cargarHistorial(\'Cliente 1\')">
                                            <i class="fas fa-eye"></i> Ver Historial
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cliente 2</td>
                                    <td>$3,000</td>
                                    <td>3 meses</td>
                                    <td>10/01/2025</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorialPago" onclick="cargarHistorial(\'Cliente 2\')">
                                            <i class="fas fa-eye"></i> Ver Historial
                                        </button>
                                    </td>
                                </tr>
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

<script>
function cargarHistorial(cliente) {
    // Lógica para cargar el historial dinámicamente (puede conectarse al backend)
    const historial = `
        <p><strong>Cliente:</strong> ${cliente}</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha de Pago</th>
                    <th>Monto</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01/01/2025</td>
                    <td>$1,000</td>
                    <td>Pagado</td>
                </tr>
                <tr>
                    <td>15/01/2025</td>
                    <td>$500</td>
                    <td>Pendiente</td>
                </tr>
            </tbody>
        </table>
    `;
    document.getElementById("contenidoHistorial").innerHTML = historial;
}
</script>
';

include '../templates/dashboard_layout.php';
?>

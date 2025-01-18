<?php
$pageTitle = "Pagos";
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Resumen de los pagos -->
        <div class="row">
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
                                    <th>Monto Pagado</th>
                                    <th>Fecha de Pago</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de un pago realizado -->
                                <tr>
                                    <td>Cliente 1</td>
                                    <td>$500</td>
                                    <td>10/01/2025</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                    <td>
                                        <!-- Solo mostrar detalles del pago, sin botón de pago -->
                                        <a href="#" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles"><i class="fas fa-eye"></i> Ver</a>
                                    </td>
                                </tr>

                                <!-- Ejemplo de un pago pendiente -->
                                <tr>
                                    <td>Cliente 2</td>
                                    <td>$300</td>
                                    <td>12/01/2025</td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                    <td>
                                        <!-- Botón para registrar pago -->
                                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar pago"><i class="fas fa-check"></i> Registrar Pago</a>
                                    </td>
                                </tr>

                                <!-- Ejemplo de un pago con demora -->
                                <tr>
                                    <td>Cliente 3</td>
                                    <td>$200</td>
                                    <td>15/01/2025</td>
                                    <td><span class="badge bg-danger">Con Demora</span></td>
                                    <td>
                                        <!-- Botón para registrar pago con demora -->
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar pago con demora"><i class="fas fa-clock"></i> Pago con Demora</a>
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
';

include '../templates/dashboard_layout.php';
?>

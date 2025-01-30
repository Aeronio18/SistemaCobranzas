<?php
$pageTitle = "Dashboard Cobrador";
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
                        <h3 class="card-title">Pagos</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                        <p>Consulta y gestiona los pagos realizados.</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="pagos.php" class="btn btn-outline-primary"><i class="fas fa-eye"></i> Ver</a>
                    </div>
                </div>
            </div>

            <!-- Rutas -->
            <div class="col-lg-6 col-12">
                <div class="card card-info h-100">
                    <div class="card-header">
                        <h3 class="card-title">Rutas</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-route fa-3x mb-3"></i>
                        <p>Consulta las rutas de cobro disponibles.</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="rutas.php" class="btn btn-outline-info"><i class="fas fa-eye"></i> Ver</a>
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
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de un cliente con cobro pendiente -->
                                <tr>
                                    <td>Cliente 1</td>
                                    <td>Calle 123, Ciudad</td>
                                    <td>$500</td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Pago Realizado</a>
                                    </td>
                                </tr>

                                <!-- Ejemplo de un cliente con cobro pagado -->
                                <tr>
                                    <td>Cliente 2</td>
                                    <td>Avenida 456, Ciudad</td>
                                    <td>$300</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                    <td>
                                        <!-- No aparece botón de pago realizado si ya está pagado -->
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

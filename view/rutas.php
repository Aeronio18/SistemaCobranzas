<?php
$pageTitle = "Rutas";
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Resumen de las rutas -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Resumen de las Rutas - ' . date('d/m/Y') . '</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Dirección</th>
                                    <th>Número de Contacto</th>
                                    <th>Número de Pagos Pendientes</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de un cliente con cobro pendiente -->
                                <tr>
                                    <td>Cliente 1</td>
                                    <td>Calle 123, Ciudad</td>
                                    <td>(123) 456-7890</td>
                                    <td>5</td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Pago Realizado</a>
                                    </td>
                                </tr>

                                <!-- Ejemplo de un cliente con cobro pagado -->
                                <tr>
                                    <td>Cliente 2</td>
                                    <td>Avenida 456, Ciudad</td>
                                    <td>(987) 654-3210</td>
                                    <td>0</td>
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

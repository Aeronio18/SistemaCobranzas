<?php
$pageTitle = "Dashboard Cliente";
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Row 1 -->
        <div class="row">
            <!-- Crédito Actual -->
            <div class="col-lg-6 col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crédito Actual</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                        <p class="card-text text-success h4">$10,000 MXN</p>
                    </div>
                </div>
            </div>
            <!-- Próximo Pago -->
            <div class="col-lg-6 col-12">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Próximo Pago</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-day fa-3x mb-3"></i>
                        <p class="card-text text-danger h4">15 Enero 2025</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row 2 -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Historial de Pagos</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01 Enero 2025</td>
                                    <td>$2,000 MXN</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                </tr>
                                <tr>
                                    <td>15 Diciembre 2024</td>
                                    <td>$2,000 MXN</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                </tr>
                                <tr>
                                    <td>01 Diciembre 2024</td>
                                    <td>$2,000 MXN</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
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

<?php
$pageTitle = "Dashboard Cobrador";
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Row 1 -->
        <div class="row">
            <!-- Cobros Pendientes -->
            <div class="col-lg-4 col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Cobros Pendientes</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x mb-3"></i>
                        <p>Consulta los cobros pendientes de realizar.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i> Ver</a>
                    </div>
                </div>
            </div>
            <!-- Cobros Realizados -->
            <div class="col-lg-4 col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Cobros Realizados</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-check fa-3x mb-3"></i>
                        <p>Revisa los cobros que ya han sido realizados.</p>
                        <a href="#" class="btn btn-outline-success"><i class="fas fa-eye"></i> Ver</a>
                    </div>
                </div>
            </div>
            <!-- Registrar Solicitud -->
            <div class="col-lg-4 col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Solicitud</h3>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-edit fa-3x mb-3"></i>
                        <p>Registrar nuevas solicitudes de cobro.</p>
                        <a href="#" class="btn btn-outline-warning"><i class="fas fa-plus"></i> Registrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
';

include '../templates/dashboard_layout.php';
?>

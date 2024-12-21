<?php
$pageTitle = "Dashboard Cobrador";
$content = '
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Cobros Pendientes</h5>
                <a href="#" class="btn btn-primary"><i class="fas fa-clock"></i> Ver</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Cobros Realizados</h5>
                <a href="#" class="btn btn-primary"><i class="fas fa-check"></i> Ver</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Registrar Solicitud</h5>
                <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i> Ver</a>
            </div>
        </div>
    </div>
</div>';
include '../templates/dashboard_layout.php';

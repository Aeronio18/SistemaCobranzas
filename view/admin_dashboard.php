<?php
$pageTitle = "Dashboard Admin";
$content = '
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Cobradores</h5>
                <a href="#" class="btn btn-primary"><i class="fas fa-users"></i> Ver</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Créditos</h5>
                <a href="#" class="btn btn-primary"><i class="fas fa-wallet"></i> Ver</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Solicitudes</h5>
                <a href="#" class="btn btn-primary"><i class="fas fa-file-alt"></i> Ver</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">CRUD</h5>
                <a href="#" class="btn btn-primary"><i class="fas fa-tools"></i> Ver</a>
            </div>
        </div>
    </div>
</div>';
include '../templates/dashboard_layout.php';

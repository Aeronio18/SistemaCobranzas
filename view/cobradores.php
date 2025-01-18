<?php
$pageTitle = "Cobradores";
$content = '
<div class="row g-4">
    <!-- Tarjeta para registrar un nuevo cobrador -->
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-success h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-user-plus fa-3x mb-4"></i>
                <h5 class="card-title">Nuevo Asesor</h5>
                <p class="card-text">Registrar un nuevo cobrador.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="#" class="btn btn-light btn-sm">Registrar</a>
            </div>
        </div>
    </div>

    <!-- Listado de cobradores en tarjetas -->
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-primary h-100">
            <div class="card-body text-center">
                <h5 class="card-title">Asesor 1</h5>
                <p class="card-text">Activo</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-primary h-100">
            <div class="card-body text-center">
                <h5 class="card-title">Asesor 2</h5>
                <p class="card-text">Inactivo</p>
            </div>
        </div>
    </div>
</div>';
include '../templates/dashboard_layout.php';
?>

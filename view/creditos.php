<?php
$pageTitle = "Créditos";
$content = '
<div class="row g-4">
    <!-- Tarjeta para registrar un nuevo crédito -->
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-success h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                <h5 class="card-title">Nuevo Crédito</h5>
                <p class="card-text">Registrar un nuevo crédito.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="#" class="btn btn-light btn-sm w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar un nuevo crédito">
                    <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Resumen de créditos -->
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-primary h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-coins fa-3x mb-3"></i>
                <h5 class="card-title">Créditos Actuales</h5>
                <p class="card-text">10 créditos activos</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-warning h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-hourglass-half fa-3x mb-3"></i>
                <h5 class="card-title">Créditos Pendientes</h5>
                <p class="card-text">5 créditos pendientes hoy</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-secondary h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-3x mb-3"></i>
                <h5 class="card-title">Créditos Finalizados</h5>
                <p class="card-text">8 créditos completados</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de créditos -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-table"></i> Listado de Créditos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Cantidad Solicitada</th>
                            <th>Fecha Solicitada</th>
                            <th>Periodo de Pagos</th>
                            <th>Pagos Pendientes</th>
                            <th>Total</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cliente 1</td>
                            <td>$500</td>
                            <td>10/01/2025</td>
                            <td>12 meses</td>
                            <td>5</td>
                            <td>$600</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Registrar Pago">
                                    <i class="fas fa-dollar-sign"></i>
                                </a>
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Pago con Demora">
                                    <i class="fas fa-exclamation-circle"></i>
                                </a>
                                <a href="#" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Liquidado">
                                    <i class="fas fa-check"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>';
include '../templates/dashboard_layout.php';
?>

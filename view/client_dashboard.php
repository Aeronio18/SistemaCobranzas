<?php
$pageTitle = "Dashboard Cliente";
$content = '
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Crédito Actual</h5>
                <p class="card-text text-success h4">$10,000 MXN</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Próximo Pago</h5>
                <p class="card-text text-danger h4">15 Enero 2025</p>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <h5>Historial de Pagos</h5>
    <table class="table table-striped">
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
                <td>Pagado</td>
            </tr>
            <tr>
                <td>15 Diciembre 2024</td>
                <td>$2,000 MXN</td>
                <td>Pagado</td>
            </tr>
            <tr>
                <td>01 Diciembre 2024</td>
                <td>$2,000 MXN</td>
                <td>Pagado</td>
            </tr>
        </tbody>
    </table>
</div>';
include '../templates/dashboard_layout.php';

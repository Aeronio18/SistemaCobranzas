<?php
$pageTitle = "Dashboard Admin";
$content = '
<div class="row g-4">
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-primary h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x mb-4"></i>
                <h5 class="card-title">Asesores</h5>
                <p class="card-text">Gestión de todos los asesores.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="cobradores.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-success h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-wallet fa-3x mb-4"></i>
                <h5 class="card-title">Créditos</h5>
                <p class="card-text">Consulta los créditos otorgados.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="creditos.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-warning h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-file-alt fa-3x mb-4"></i>
                <h5 class="card-title">Clientes</h5>
                <p class="card-text">Administra los clientes existentes.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="clientes.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-danger h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-tools fa-3x mb-4"></i>
                <h5 class="card-title">Configuracion</h5>
                <p class="card-text">Gestiona datos del sistema.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="#" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
    <!-- Resumen debajo de las tarjetas -->
<div class="row mt-4">
    <!-- Asesores Activos -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Asesores Activos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cobrador</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cobrador 1</td>
                            <td>Activo</td>
                        </tr>
                        <tr>
                            <td>Cobrador 2</td>
                            <td>Inactivo</td>
                        </tr>
                        <tr>
                            <td>Cobrador 3</td>
                            <td>Activo</td>
                        </tr>
                    </tbody>
                </table>
                <p><strong>Estatus de créditos:</strong> Cobrados: 15, Pendientes: 10</p>
            </div>
        </div>
    </div>
    
    <!-- Créditos -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Créditos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Crédito Actual</th>
                            <th>Próximo Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cliente 1</td>
                            <td>$500</td>
                            <td>15/01/2024</td>
                        </tr>
                        <tr>
                            <td>Cliente 2</td>
                            <td>$300</td>
                            <td>20/01/2024</td>
                        </tr>
                        <tr>
                            <td>Cliente 3</td>
                            <td>$700</td>
                            <td>05/02/2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Solicitudes Pendientes -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Solicitudes Pendientes</h5>
            </div>
            <div class="card-body">
                <p><strong>Solicitudes de Aprobación:</strong></p>
                <ul>
                    <li>Solicitud de Crédito - Pendiente</li>
                    <li>Solicitud de Finalización de Crédito - Pendiente</li>
                    <li>Solicitud de Aprobación de Pago - Pendiente</li>
                </ul>
                <p><strong>Total de Solicitudes Pendientes:</strong> 3</p>
            </div>
        </div>
    </div>
</div>

<!-- Gráficas de Estatus de Créditos y Solicitudes -->
<div class="row mt-4">
    <!-- Gráfica de Estatus de Créditos -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Estatus de Créditos</h5>
            </div>
            <div class="card-body">
                <canvas id="creditStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Gráfica de Solicitudes Pendientes -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Solicitudes Pendientes</h5>
            </div>
            <div class="card-body">
                <canvas id="requestStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>';

include '../templates/dashboard_layout.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfica de Estatus de Créditos
    var ctx1 = document.getElementById('creditStatusChart').getContext('2d');
    var creditStatusChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Cobrados', 'Pendientes'],
            datasets: [{
                data: [15, 10], // Datos ficticios
                backgroundColor: ['#28a745', '#dc3545']
            }]
        }
    });

    // Gráfica de Solicitudes Pendientes
    var ctx2 = document.getElementById('requestStatusChart').getContext('2d');
    var requestStatusChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Créditos Nuevos', 'Aprobación de Pagos', 'Finalización de Créditos'],
            datasets: [{
                label: 'Solicitudes Pendientes',
                data: [1, 1, 1], // Datos ficticios
                backgroundColor: ['#007bff', '#ffc107', '#dc3545']
            }]
        }
    });
</script>


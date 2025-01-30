<?php
$pageTitle = "Dashboard Asist";
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
                <i class="fas fa-route fa-3x mb-4"></i>
                <h5 class="card-title">Rutas</h5>
                <p class="card-text">Avance de las rutas por asesor.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="route.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-info h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x mb-4"></i>
                <h5 class="card-title">Clientes</h5>
                <p class="card-text">Gestiona los clientes registrados.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="clientes.php" class="btn btn-light btn-sm">Ver más</a>
            </div>
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
                            <th>Asesor</th>
                            <th>Créditos por Cobrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Asesor 1</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Asesor 2</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Asesor 3</td>
                            <td>8</td>
                        </tr>
                    </tbody>
                </table>
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
    
    <!-- Rutas -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Rutas</h5>
            </div>
            <div class="card-body">
                <p><strong>Avance por Asesor:</strong></p>
                <ul>
                    <li>Asesor 1: 60%</li>
                    <li>Asesor 2: 40%</li>
                    <li>Asesor 3: 75%</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Gráficas -->
<div class="row mt-4">
    <!-- Gráfica de Avance General de la Ruta -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Avance General de la Ruta</h5>
            </div>
            <div class="card-body">
                <canvas id="generalRouteChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Gráfica de Avance por Asesor -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Avance de la Ruta por Asesor</h5>
            </div>
            <div class="card-body">
                <canvas id="routeByAdvisorChart"></canvas>
            </div>
        </div>
    </div>
</div>';

include '../templates/dashboard_layout.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfica de Avance General de la Ruta
    var ctx1 = document.getElementById("generalRouteChart").getContext("2d");
    new Chart(ctx1, {
        type: "doughnut",
        data: {
            labels: ["Completado", "Pendiente"],
            datasets: [{
                data: [70, 30],
                backgroundColor: ["#28a745", "#dc3545"]
            }]
        }
    });

    // Gráfica de Avance por Asesor
    var ctx2 = document.getElementById("routeByAdvisorChart").getContext("2d");
    new Chart(ctx2, {
        type: "bar",
        data: {
            labels: ["Asesor 1", "Asesor 2", "Asesor 3"],
            datasets: [{
                label: "Avance (%)",
                data: [60, 40, 75],
                backgroundColor: ["#007bff", "#ffc107", "#28a745"]
            }]
        }
    });
</script>

<?php
$pageTitle = "Avance de Rutas del Día";
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Avance General de las Rutas -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Avance General de las Rutas del Día - ' . date('d/m/Y') . '</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <!-- Progress bar circular usando ProgressBar.js -->
                        <div class="text-center" style="margin-right: 30px;">
                            <div id="progress-circle" style="width: 100px; height: 100px;"></div>
                        </div>
                        <div class="ml-4">
                            <p><strong>Total Clientes:</strong> 100</p>
                            <p><strong>Clientes Atendidos:</strong> 75</p>
                            <p><strong>Clientes Restantes:</strong> 25</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Avance Individual por Asesor -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Avance de Asesores - ' . date('d/m/Y') . '</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Asesor</th>
                                    <th>Créditos por Cobrar</th>
                                    <th>Créditos Cobrados</th>
                                    <th>Créditos por Atender</th>
                                    <th>Avance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de un asesor -->
                                <tr>
                                    <td>Juan Pérez</td>
                                    <td>10</td>
                                    <td>5</td>
                                    <td>3</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Ejemplo de otro asesor -->
                                <tr>
                                    <td>Ana Gómez</td>
                                    <td>8</td>
                                    <td>8</td>
                                    <td>0</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Otro ejemplo -->
                                <tr>
                                    <td>Carlos Ramírez</td>
                                    <td>5</td>
                                    <td>3</td>
                                    <td>2</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>';

include '../templates/dashboard_layout.php';
?>
<!-- Incluir ProgressBar.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>
<!-- Script para ProgressBar.js -->
<script>
    // Crear la barra de progreso circular usando ProgressBar.js
    var progress = new ProgressBar.Circle('#progress-circle', {
        strokeWidth: 10,  // Mantener el grosor de la barra
        color: '#4caf50',
        trailColor: '#eee',
        trailWidth: 2,
        duration: 1400,
        easing: 'easeInOut',
        text: {
            style: {
                fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif',
                fontSize: '1.5rem',  // Ajustar el tamaño del texto
                fontWeight: 'bold',
                color: '#4caf50',
            },
            autoStyleContainer: false,
            position: 'center',
            value: '75%', // Valor de porcentaje
        },
        from: { color: '#eee', width: 1 },
        to: { color: '#4caf50', width: 10 },
    });

    // Iniciar la animación con el porcentaje dinámico
    progress.animate(0.75);  // 75% de avance
</script>

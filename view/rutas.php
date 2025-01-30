<?php
$pageTitle = "Rutas";
$content = '
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Avance de la Ruta -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Avance de la Ruta del Día - ' . date('d/m/Y') . '</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <!-- Progress bar circular usando ProgressBar.js -->
                        <div class="text-center" style="margin-right: 30px;">
                            <div id="progress-circle" style="width: 100px; height: 120px;"></div>
                        </div>
                        <div class="ml-4">
                            <p><strong>Total Clientes:</strong> 20</p>
                            <p><strong>Clientes Atendidos:</strong> 15</p>
                            <p><strong>Clientes Restantes:</strong> 5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de las rutas -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Resumen de las Rutas - ' . date('d/m/Y') . '</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Dirección</th>
                                    <th>Número de Contacto</th>
                                    <th>Número de Pagos Pendientes</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de un cliente con cobro pendiente -->
                                <tr>
                                    <td>Cliente 1</td>
                                    <td>Calle 123, Ciudad</td>
                                    <td>(123) 456-7890</td>
                                    <td>5</td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Pago Realizado</a>
                                    </td>
                                </tr>

                                <!-- Ejemplo de un cliente con cobro pagado -->
                                <tr>
                                    <td>Cliente 2</td>
                                    <td>Avenida 456, Ciudad</td>
                                    <td>(987) 654-3210</td>
                                    <td>0</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                    <td>
                                        <!-- No aparece botón de pago realizado si ya está pagado -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Estilos para la progress bar circular -->
<style>
.circular-chart {
    display: block;
    margin: 10px auto;
    max-width: 100%;
    max-height: 250px;
}
.circle-bg {
    fill: none;
    stroke: #eee;
    stroke-width: 5; /* Grosor de la barra */
}
.circle {
    fill: none;
    stroke-width: 6; /* Haciendo la barra más gruesa */
    stroke-linecap: round;
    stroke: #4caf50;
    animation: progress 1s ease-out forwards;
}
@keyframes progress {
    from {
        stroke-dasharray: 0 100;
    }
    to {
        stroke-dasharray: 75 100; /* Cambia "75" por el porcentaje dinámico */
    }
}
</style>
';

include '../templates/dashboard_layout.php';
?>

<!-- Incluir ProgressBar.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>

<!-- Script para ProgressBar.js -->
<script>
    // Crear la barra de progreso circular usando ProgressBar.js
    var progress = new ProgressBar.Circle('#progress-circle', {
        strokeWidth: 6,  // Barra más gruesa
        color: '#4caf50',
        trailColor: '#eee',
        trailWidth: 2,
        duration: 1400,
        easing: 'easeInOut',
        text: {
            style: {
                fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif',
                fontSize: '2rem',
                fontWeight: 'bold',
                color: '#4caf50',
            },
            autoStyleContainer: false,
            position: 'center',
            value: '75%', // Porcentaje dinámico
        },
        from: { color: '#eee', width: 1 },
        to: { color: '#4caf50', width: 6 },
    });

    // Iniciar la animación con el porcentaje dinámico
    progress.animate(0.75);  // 75% de avance
</script>

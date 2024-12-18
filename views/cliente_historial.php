<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'cliente') {
    header("Location: /sandbox/login");
    exit();
}
include_once __DIR__ . '/../templates/header.php';
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-history"></i> Historial de Pagos
                    </div>
                    <div class="card-body">
                        <p>Consulta y gestiona el historial de pagos del cliente.</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01/01/2022</td>
                                    <td>$1000</td>
                                    <td>Pagado</td>
                                </tr>
                                <tr>
                                    <td>01/02/2022</td>
                                    <td>$1000</td>
                                    <td>Pagado</td>
                                </tr>
                                <!-- Más filas según sea necesario -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once __DIR__ . '/../templates/footer.php'; ?>

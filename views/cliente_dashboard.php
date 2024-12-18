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
            <div class="col-lg-4 col-6">
                <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header">
                        <i class="fas fa-user"></i> Información
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Información del Cliente</h5>
                        <p class="card-text">Consulta y gestiona la información del cliente.</p>
                        <a href="/sandbox/views/cliente_informacion.php" class="btn btn-light">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">
                        <i class="fas fa-hand-holding-usd"></i> Crédito
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Crédito Actual</h5>
                        <p class="card-text">Consulta y gestiona el crédito actual del cliente.</p>
                        <a href="/sandbox/views/cliente_credito" class="btn btn-light">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header">
                        <i class="fas fa-calendar-alt"></i> Próximo Pago
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Próxima Fecha de Pago</h5>
                        <p class="card-text">Consulta y gestiona la próxima fecha de pago del cliente.</p>
                        <a href="/sandbox/views/cliente_proximo_pago" class="btn btn-light">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once __DIR__ . '/../templates/footer.php'; ?>

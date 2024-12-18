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
                        <i class="fas fa-user"></i> Información del Cliente
                    </div>
                    <div class="card-body">
                        <p>Detalles de la información del cliente.</p>
                        <a href="/sandbox/views/cliente_historial.php" class="btn btn-primary">Ver Historial</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once __DIR__ . '/../templates/footer.php'; ?>

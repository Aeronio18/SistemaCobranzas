<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'cobrador') {
    header("Location: /sandbox/login");
    exit();
}
include_once __DIR__ . '/../templates/header.php';
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">
                        <i class="fas fa-exclamation-circle"></i> Pendientes
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Cobros Pendientes</h5>
                        <p class="card-text">Consulta y gestiona los cobros pendientes del sistema.</p>
                        <a href="#" class="btn btn-light">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">
                        <i class="fas fa-check-circle"></i> Realizados
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Cobros Realizados</h5>
                        <p class="card-text">Consulta y gestiona los cobros realizados del sistema.</p>
                        <a href="#" class="btn btn-light">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header">
                        <i class="fas fa-file-alt"></i> Solicitudes
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Lista de Solicitudes</h5>
                        <p class="card-text">Consulta y gestiona las solicitudes del sistema.</p>
                        <a href="#" class="btn btn-light">Más información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once __DIR__ . '/../templates/footer.php'; ?>

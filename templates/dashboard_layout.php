<?php
// Inicia la sesión si aún no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtén el rol del usuario o asigna uno por defecto
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <style>
        /* Aseguramos que el contenido principal ocupe toda la altura disponible */
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Hace que el contenido principal ocupe todo el espacio disponible */
        .container-fluid {
            flex: 1;
        }

        /* Asegura que el footer quede al final */
        footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!-- Botón para el menú móvil -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menú de navegación -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav d-flex w-100 justify-content-between">
            <!-- Logo y nombre del sitio a la izquierda -->
            <li class="nav-item ms-3"> <!-- ms-3 agrega margen izquierdo -->
                <a class="navbar-brand d-flex align-items-center" href="">
                    <img src="../img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                    <span class="ms-4">MiSistema</span>
                </a>
            </li>

            <!-- Menú de navegación según el rol del usuario -->
            <li class="nav-item">
                <?php if (isset($_SESSION['role'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a class="nav-link" href="../view/admin_dashboard.php">Dashboard Admin</a>
                    <?php elseif ($_SESSION['role'] === 'cobrador'): ?>
                        <a class="nav-link" href="../view/collector_dashboard.php">Dashboard Cobrador</a>
                    <?php elseif ($_SESSION['role'] === 'cliente'): ?>
                        <a class="nav-link" href="../view/client_dashboard.php">Dashboard Cliente</a>
                    <?php endif; ?>
                <?php endif; ?>
            </li>

            <!-- Enlace de "Cerrar sesión" alineado a la derecha -->
            <li class="nav-item ms-auto me-3"> <!-- ms-auto alinea a la derecha, me-3 agrega margen derecho -->
                <a class="nav-link text-danger" href="../controllers/LogoutController.php">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky">
                <ul class="nav flex-column text-white">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-users"></i> Cobradores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-wallet"></i> Créditos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-file-alt"></i> Solicitudes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-tools"></i> CRUD
                            </a>
                        </li>
                    <?php elseif ($role === 'cobrador'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-clock"></i> Cobros Pendientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-check"></i> Cobros Realizados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-edit"></i> Registrar Solicitud
                            </a>
                        </li>
                    <?php elseif ($role === 'cliente'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-credit-card"></i> Crédito Actual
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-calendar"></i> Próximo Pago
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-history"></i> Historial de Pagos
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-user"></i> Perfil
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <div class="container">
                <!-- Contenido dinámico -->
                <?php if (isset($content)) echo $content; ?>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-3 text-center">
    <p>&copy; 2024 MiSistema. Todos los derechos reservados.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

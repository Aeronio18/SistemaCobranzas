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
        /* Estilo personalizado para el sidebar */
        #sidebarMenu {
            background-color: #343a40;
            color: #fff;
            min-height: 100vh;
        }

        #sidebarMenu .nav-link {
            color: #fff;
        }

        #sidebarMenu .nav-link:hover {
            background-color: #495057;
        }

        /* Estilo personalizado para los cards */
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .card-text {
            font-size: 1rem;
        }

        /* Mejorar la visibilidad en dispositivos pequeños */
        @media (max-width: 768px) {
            #sidebarMenu {
                display: none;
            }

            .navbar .navbar-toggler {
                display: block;
            }

            .main-content {
                padding-left: 0;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav d-flex w-100 justify-content-between">
            <li class="nav-item ms-3">
                <a class="navbar-brand d-flex align-items-center" href="">
                    <img src="../img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                    <span class="ms-4">MiSistema</span>
                </a>
            </li>

            <li class="nav-item ms-auto me-3">
                <a class="nav-link text-danger" href="../controllers/LogoutController.php">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i> Cobradores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-wallet"></i> Créditos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-alt"></i> Solicitudes
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Admin</h1>
            </div>
            <div class="container">
                <!-- Contenido dinámico -->
                <?php if (isset($content)) echo $content; ?>
            </div>
        </main>
    </div>
</div>

<footer class="bg-dark text-white py-3 text-center">
    <p>&copy; 2024 MiSistema. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

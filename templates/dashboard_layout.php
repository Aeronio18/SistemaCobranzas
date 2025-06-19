<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? null;
$username = $_SESSION['username'] ?? "Usuario";

if ($role === 'cobrador') {
    $numero_asesor = substr($username, 1);
    include '../database/db.php';
    $sql = "SELECT nombre FROM asesores WHERE nombre_usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$numero_asesor]);
    $asesor = $stmt->fetch();
    $nombre_asesor = $asesor['nombre'] ?? $username;
    $welcome_message = "Bienvenido " . htmlspecialchars(str_replace('_', ' ', $nombre_asesor));
} else {
    $welcome_message = "Bienvenido " . htmlspecialchars(str_replace('_', ' ', $username));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? "Panel"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/cimeli.ico" type="image/x-icon">

    <style>
        :root {
            --rojo: #dc3545;
            --verde: #198754;
            --azul: #0d6efd;
            --blanco: #ffffff;
            --gris-claro: #f8f9fa;
            --gris-texto: #343a40;
            --gris-hover: #e9ecef;
        }

        body {
            background-color: var(--gris-claro);
            color: var(--gris-texto);
        }

        .navbar {
            background-color: var(--blanco);
            border-bottom: 1px solid #dee2e6;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: var(--gris-texto);
            font-weight: bold;
        }

        .navbar .nav-link:hover {
            color: var(--rojo);
        }

        #sidebarMenu {
            background-color: var(--blanco);
            border-right: 1px solid #dee2e6;
            min-height: 100vh;
        }

        #sidebarMenu .nav-link {
            color: var(--gris-texto);
            transition: background-color 0.3s, color 0.3s;
        }

        #sidebarMenu .nav-link:hover,
        #sidebarMenu .nav-link.active {
            background-color: var(--gris-hover);
            color: var(--azul);
        }

        .card {
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            background-color: var(--blanco);
        }

        .card .card-body {
            padding: 1.5rem;
        }

        .card .card-title {
            font-weight: bold;
        }

        .card.bg-azul {
            background-color: var(--azul);
            color: var(--blanco);
        }

        .card.bg-verde {
            background-color: var(--verde);
            color: var(--blanco);
        }

        .card.bg-rojo {
            background-color: var(--rojo);
            color: var(--blanco);
        }

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
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="">
            <img src="../img/cimeli.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
            <span class="ms-3">Cimeli y asociados</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../controllers/LogoutController.php">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column pt-3">
                    <li class="nav-item">
                        <a class="nav-link" href="../view/<?php echo $role; ?>_dashboard.php">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/cobradores.php">
                                <i class="fas fa-users"></i> Asesores
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/creditos.php">
                                <i class="fas fa-wallet"></i> Créditos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/clientes.php">
                                <i class="fas fa-file-alt"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/corte_semanal.php">
                                <i class="fas fa-chart-line"></i> Corte semanal
                            </a>
                        </li>
                    <?php elseif ($role === 'cobrador'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/rutas.php">
                                <i class="fas fa-route"></i> Rutas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/pagos.php">
                                <i class="fas fa-money-check-alt"></i> Pagos
                            </a>
                        </li>
                    <?php elseif ($role === 'cliente'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/client_creditos.php">
                                <i class="fas fa-money-bill-wave"></i> Mis Créditos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../view/client_historial.php">
                                <i class="fas fa-history"></i> Historial
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-center text-md-start"><?php echo $welcome_message; ?></h1>
            </div>
            <div class="container">
                <?php if (isset($content)) echo $content; ?>
            </div>
        </main>
    </div>
</div>

<?php require '../templates/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

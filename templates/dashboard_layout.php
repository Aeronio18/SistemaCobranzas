<?php
// Inicia la sesión si aún no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtén el rol del usuario directamente desde la sesión
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Obtén el nombre del usuario o asigna uno genérico
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Usuario";

// Si el rol es cobrador, buscar el nombre en la tabla de asesores
if ($role === 'cobrador') {
    // Extraemos el número de asesor del nombre de usuario (eliminamos la primera letra)
    $numero_asesor = substr($username, 1); // Tomamos el número después de la primera letra

    // Realizar la consulta para obtener el nombre del asesor
    include '../database/db.php';
    $sql = "SELECT nombre FROM asesores WHERE numero_asesor = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$numero_asesor]);
    $asesor = $stmt->fetch();

    if ($asesor) {
        // Si encontramos el asesor, usamos su nombre
        $nombre_asesor = $asesor['nombre'];
    } else {
        // Si no encontramos el asesor, usamos el nombre de usuario como respaldo
        $nombre_asesor = $username;
    }

    // Usamos el nombre del asesor
    $welcome_message = "Bienvenido " . htmlspecialchars(str_replace('_', ' ', $nombre_asesor));
} else {
    // Para roles de admin o asist, mostramos el nombre de usuario tal cual
    $welcome_message = "Bienvenido " . htmlspecialchars(str_replace('_', ' ', $username));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    
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

        /* Estilo para tarjetas AdminLTE */
        .card {
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card .card-body {
            padding: 1.5rem;
        }

        .card .card-title {
            font-weight: bold;
        }

        .card.text-bg-primary {
            background-color: #0d6efd;
            color: white;
        }

        .card.text-bg-success {
            background-color: #198754;
            color: white;
        }

        .card.text-bg-warning {
            background-color: #ffc107;
            color: black;
        }

        .card.text-bg-danger {
            background-color: #dc3545;
            color: white;
        }

        /* Ajustes para dispositivos pequeños */
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
                <!-- Contenido dinámico -->
                <?php if (isset($content)) echo $content; ?>
            </div>
        </main>
    </div>

<?php require '../templates/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

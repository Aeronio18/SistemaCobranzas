<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Server mode -->
    <link rel="stylesheet" href="/assets/css/styles.css">
    <!-- <link rel="stylesheet" href="/sandbox/assets/css/styles.css"> -->
    <title>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['username'])) {
            echo "Bienvenido " . htmlspecialchars($_SESSION['username']) . " | ";
            if (isset($_SESSION['role'])) {
                switch ($_SESSION['role']) {
                    case 'admin':
                        echo "adminDashboard";
                        break;
                    case 'cobrador':
                        echo "cobradorDashboard";
                        break;
                    case 'cliente':
                        echo "clienteDashboard";
                        break;
                    default:
                        echo "SandBox";
                        break;
                }
            }
        } else {
            echo "SandBox";
        }
        ?>
    </title>
</head>
<body class="hold-transition layout-fixed">
<div class="wrapper">
    <?php if (!isset($hideNav) || !$hideNav): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Mi Sistema</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/sandbox/views/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/sandbox/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    <?php endif; ?>
    <div class="content-wrapper">

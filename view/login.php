<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Iniciar sesión'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/cimeli.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 120px;
        }

        .form-floating .form-control {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating label {
            color: #6c757d;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.2s ease-in-out;
        }

        .form-floating .form-control:focus ~ label,
        .form-floating .form-control:not(:placeholder-shown) ~ label {
            transform: translateY(-1.5rem);
            font-size: 0.875rem;
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
$financial_tips = [
    "Ahorra al menos el 20% de tus ingresos cada mes.",
    "Evita las deudas innecesarias y prioriza pagar las tarjetas de crédito.",
    "Establece un fondo de emergencia para cubrir gastos inesperados.",
    "Invierte en educación financiera para tomar mejores decisiones.",
    "Realiza un presupuesto mensual para controlar tus gastos."
];

$random_tip = $financial_tips[array_rand($financial_tips)];
?>

<section class="vh-100 d-flex justify-content-center align-items-center">
    <div class="login-container">
        <!-- Logo centrado arriba -->
        <img src="../img/cimeli.png" class="logo" alt="Logo">

        <h2 class="text-center mb-4">Iniciar sesión</h2>

        <!-- Consejo financiero -->
        <div class="p-3 mb-3 text-center" style="background-color: rgba(13, 110, 253, 0.1); border: 1px solid #0d6efd; border-radius: 8px;">
            <span style="font-style: italic; color: #495057;">
                <strong>Consejo financiero:</strong> <?php echo $random_tip; ?>
            </span>
        </div>

        <form id="loginForm" action="../controllers/LoginController.php" method="POST">
            <div class="form-floating mb-3">
                <input type="text" id="username" name="username" class="form-control" placeholder="Nombre de usuario" required>
                <label for="username">Nombre de usuario</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                <label for="password">Contraseña</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Iniciar sesión</button>
            </div>
        </form>
    </div>
</section>

<script>
    // Validación de campos vacíos antes de enviar el formulario
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (username === '' || password === '') {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campos vacíos',
                text: 'Por favor, complete todos los campos antes de continuar.',
                confirmButtonColor: '#007bff'
            });
        }
    });

    // Mostrar SweetAlert si hay un error en la URL
    <?php if (isset($_GET['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error de inicio de sesión',
            text: 'Nombre de usuario o contraseña incorrectos.',
            confirmButtonColor: '#d33'
        });
    <?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Iniciar sesion'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
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

        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php
// Definir consejos de finanzas en un arreglo.
$financial_tips = [
    "Ahorra al menos el 20% de tus ingresos cada mes.",
    "Evita las deudas innecesarias y prioriza pagar las tarjetas de crédito.",
    "Establece un fondo de emergencia para cubrir gastos inesperados.",
    "Invierte en educación financiera para tomar mejores decisiones.",
    "Realiza un presupuesto mensual para controlar tus gastos."
];

// Seleccionar un consejo aleatorio.
$random_tip = $financial_tips[array_rand($financial_tips)];
?>

<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="../img/logo.png" class="img-fluid" alt="Imagen login">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <!-- Título -->
                <h2 class="text-center mb-4">Iniciar sesión</h2>

                <!-- Consejo financiero con fondo transparente -->
                <div class="p-3 mb-4 text-center" style="background-color: rgba(13, 110, 253, 0.1); border: 1px solid #0d6efd; border-radius: 8px;">
                    <span style="font-style: italic; color: #495057;">
                        <strong>Consejo financiero:</strong> <?php echo $random_tip; ?>
                    </span>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center">Nombre de usuario o contraseña incorrectos.</div>
                <?php endif; ?>
                <form id="loginForm" action="../controllers/LoginController.php" method="POST">
                    <!-- Username input -->
                    <div class="form-floating mb-4">
                        <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Nombre de usuario" required>
                        <label for="username">Nombre de usuario</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-floating mb-4">
                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Contraseña" required>
                        <label for="password">Contraseña</label>
                    </div>

                    <!-- Submit button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Iniciar sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (username === '' || password === '') {
            e.preventDefault();
            alert('Por favor, complete todos los campos.');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$pageTitle = "Registrar Asesor";
$content = '
<h3>Registrar Nuevo Asesor</h3>
<form action="../models/guardar_asesor.php" method="POST" id="form-registro">
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="nombre" class="form-label">
                <i class="fas fa-user"></i> Nombre del Asesor
            </label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3 col-md-6">
            <label for="contacto" class="form-label">
                <i class="fas fa-phone"></i> Número de Contacto
            </label>
            <input type="text" class="form-control" id="contacto" name="contacto" required>
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="nombre_usuario" class="form-label">
                <i class="fas fa-user-circle"></i> Nombre de Usuario
            </label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
        </div>
        <div class="mb-3 col-md-6">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Contraseña del Asesor
            </label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                    <i class="fas fa-eye" id="iconPassword"></i>
                </button>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Registrar Asesor
    </button>
    <a href="cobradores.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>
</form>';
include '../templates/dashboard_layout.php';
?>

<!-- SweetAlert y Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('error')) {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El asesor ya existe.',
        });
    }

    if (urlParams.has('error_usuario')) {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El nombre de usuario ya está en uso. Por favor elige otro.',
        });
    }

    if (urlParams.has('success')) {
        Swal.fire({
            icon: 'success',
            title: '¡Registrado!',
            text: 'El asesor ha sido registrado con éxito.',
        }).then(() => {
            window.location.href = 'cobradores.php';
        });
    }

    // Sugerir nombre de usuario al escribir el nombre
    document.getElementById("nombre").addEventListener("input", function () {
        const nombre = this.value.trim();
        if (nombre.length > 0) {
            const inicial = nombre.charAt(0).toUpperCase();
            const random = Math.random().toString(36).substring(2, 6).toUpperCase(); // 4 caracteres
            document.getElementById("nombre_usuario").value = inicial + random;
        } else {
            document.getElementById("nombre_usuario").value = '';
        }
    });

    // Mostrar/Ocultar contraseña
    document.getElementById("togglePassword").addEventListener("click", function () {
        const passwordField = document.getElementById("password");
        const icon = document.getElementById("iconPassword");
        const isPasswordVisible = passwordField.type === "text";

        passwordField.type = isPasswordVisible ? "password" : "text";
        icon.classList.toggle("fa-eye", isPasswordVisible);
        icon.classList.toggle("fa-eye-slash", !isPasswordVisible);
    });
</script>

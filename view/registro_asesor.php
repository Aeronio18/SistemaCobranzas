<?php
$pageTitle = "Registrar Asesor";
$content = '
<h3>Registrar Nuevo Asesor</h3>
<form action="../models/guardar_asesor.php" method="POST" id="form-registro">
    <div class="mb-3">
        <label for="nombre" class="form-label">
            <i class="fas fa-user"></i> Nombre del Asesor
        </label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
        <label for="contacto" class="form-label">
            <i class="fas fa-phone"></i> Número de Contacto
        </label>
        <input type="text" class="form-control" id="contacto" name="contacto" required>
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

<!-- Cargar SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const urlParams = new URLSearchParams(window.location.search);

    // Verificar si hay error en la URL
    if (urlParams.has('error')) {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El asesor ya existe.',
        });
    }

    // Verificar si hay éxito en la URL
    if (urlParams.has('success')) {
        Swal.fire({
            icon: 'success',
            title: '¡Registrado!',
            text: 'El asesor ha sido registrado con éxito.',
        }).then(() => {
            window.location.href = 'cobradores.php'; // Redirigir después de 2 segundos
        });
    }
</script>

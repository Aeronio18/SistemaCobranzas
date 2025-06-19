<?php
$pageTitle = "Asesores";

// Conexión a la base de datos
include '../database/db.php';

// Obtener los asesores registrados
$sql = "SELECT * FROM asesores";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$asesores = $stmt->fetchAll();

// Obtener el rol del usuario desde la sesión
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'admin'; // Asignar un rol predeterminado

// Generar el contenido de las tarjetas dinámicamente
$content = '<div class="row g-4">';

$content .= '
    <!-- Tarjeta para registrar un nuevo asesor -->
    <div class="col-md-3 col-sm-6">
        <div class="card text-bg-success h-100 d-flex flex-column justify-content-between">
            <div class="card-body text-center">
                <i class="fas fa-user-plus fa-3x mb-4"></i>
                <h5 class="card-title">Nuevo Asesor</h5>
                <p class="card-text">Registrar un nuevo cobrador.</p>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="registro_asesor.php" class="btn btn-light btn-sm">Registrar</a>
            </div>
        </div>
    </div>';

foreach ($asesores as $asesor) {
    $estado = $asesor['estado'] == 'activo' ? 'Activo' : 'Inactivo';
    $colorCard = $asesor['estado'] == 'activo' ? 'text-bg-primary' : 'text-bg-secondary';

    // Empieza la tarjeta
    $content .= '
    <div class="col-md-3 col-sm-6">
        <div class="card ' . $colorCard . ' h-100">
            <div class="card-body text-center">
                <h5 class="card-title">' . htmlspecialchars($asesor['nombre']) . '</h5>
                <p class="card-text">' . $estado . '</p>
                <p><strong>Contacto:</strong> ' . htmlspecialchars($asesor['contacto']) . '</p>';

    // Si el asesor está activo y el rol no es 'asist', mostrar el botón de "Dar de baja"
    if ($asesor['estado'] == 'activo' && $role !== 'asist') {
        $content .= '
                <form action="../models/dar_baja_asesor.php" method="POST">
                    <input type="hidden" name="asesor_id" value="' . $asesor['id'] . '">
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-user-times"></i> Dar de baja
                    </button>
                </form>';
    }

    // Cierra la tarjeta
    $content .= '
            </div>
        </div>
    </div>';
}

$content .= '</div>';


include '../templates/dashboard_layout.php';
?>

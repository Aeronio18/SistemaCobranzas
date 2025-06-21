<?php
// Configuración
$pageTitle = "Renovación de Crédito";

// Inicia la sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a base de datos
include '../database/db.php';

// AJAX para verificar si el cliente tiene crédito activo
if (isset($_GET['check_credito']) && is_numeric($_GET['check_credito'])) {
    $cliente_id = intval($_GET['check_credito']);
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM creditos WHERE cliente_id = :cliente_id AND fecha_termino > NOW()");
    $stmt->execute([':cliente_id' => $cliente_id]);
    echo json_encode(['tiene_credito' => $stmt->fetchColumn() > 0]);
    exit;
}

// Variables para mensajes
$error = '';
$success = '';

// Obtener clientes
$stmtClientes = $pdo->prepare("SELECT id, nombre FROM clientes ORDER BY nombre ASC");
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);

// Obtener asesores activos
$stmtAsesores = $pdo->prepare("SELECT id, nombre FROM asesores WHERE estado = 'activo' ORDER BY nombre ASC");
$stmtAsesores->execute();
$asesores = $stmtAsesores->fetchAll(PDO::FETCH_ASSOC);

// Procesar renovación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente'] ?? '';
    $asesor_id = $_POST['asesor'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_termino = $_POST['fecha_termino'] ?? '';
    $importe = $_POST['importe'] ?? '';
    $es_renovacion = 1; // porque es una renovación

    // Validación
    if (empty($cliente_id) || empty($asesor_id) || empty($fecha_inicio) || empty($fecha_termino) || empty($importe)) {
        $error = 'Por favor, complete todos los campos.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO creditos (cliente_id, asesor_id, fecha_inicio, fecha_termino, importe, es_renovacion) 
                                   VALUES (:cliente_id, :asesor_id, :fecha_inicio, :fecha_termino, :importe, :es_renovacion)");
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':asesor_id' => $asesor_id,
                ':fecha_inicio' => $fecha_inicio,
                ':fecha_termino' => $fecha_termino,
                ':importe' => $importe,
                ':es_renovacion' => $es_renovacion,
            ]);
            $success = "Renovación de crédito registrada con éxito.";
        } catch (PDOException $e) {
            $error = 'Error al registrar la renovación: ' . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="shortcut icon" href="../img/cimeli.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-container {
            max-width: 650px;
            margin: 50px auto;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        label i {
            margin-right: 6px;
            color: #198754; /* verde bootstrap */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4"><i class="fas fa-redo-alt"></i> Renovación de Crédito</h1>
    <div class="form-container">
        <form method="POST" id="form-renovacion">
            <!-- Cliente -->
            <div class="mb-3">
                <label for="cliente" class="form-label"><i class="fas fa-user"></i> Cliente</label>
                <select class="form-select" id="cliente" name="cliente" required>
                    <option value="">Seleccione un cliente</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Estado del cliente -->
            <div id="estado-cliente" class="mb-3"></div>

            <!-- Formulario oculto -->
            <div id="form-renovacion-campos" style="display: none;">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label"><i class="fas fa-calendar-check"></i> Fecha de Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_termino" class="form-label"><i class="fas fa-calendar-times"></i> Fecha de Término</label>
                        <input type="date" class="form-control" name="fecha_termino" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="importe" class="form-label"><i class="fas fa-dollar-sign"></i> Importe</label>
                    <input type="number" class="form-control" name="importe" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="asesor" class="form-label"><i class="fas fa-user-tie"></i> Asesor</label>
                    <select class="form-select" name="asesor" required>
                        <option value="">Seleccione un asesor</option>
                        <?php foreach ($asesores as $asesor): ?>
                            <option value="<?= $asesor['id'] ?>"><?= htmlspecialchars($asesor['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100"><i class="fas fa-save"></i> Renovar Crédito</button>
            </div>

            <a href="javascript:history.back()" class="btn btn-secondary w-100 mt-3">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </form>
    </div>
</div>

<!-- JavaScript para verificación en tiempo real -->
<script>
document.getElementById('cliente').addEventListener('change', function () {
    const clienteId = this.value;
    const estadoDiv = document.getElementById('estado-cliente');
    const camposForm = document.getElementById('form-renovacion-campos');

    if (!clienteId) {
        estadoDiv.innerHTML = '';
        camposForm.style.display = 'none';
        return;
    }

    fetch(`?check_credito=${clienteId}`)
        .then(response => response.json())
        .then(data => {
            if (data.tiene_credito) {
                estadoDiv.innerHTML = '<div class="alert alert-warning text-center"><i class="fas fa-exclamation-triangle"></i> Este cliente tiene un crédito pendiente. No puede renovar aún.</div>';
                camposForm.style.display = 'none';
            } else {
                estadoDiv.innerHTML = '';
                camposForm.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error al verificar crédito:', error);
            estadoDiv.innerHTML = '<div class="alert alert-danger text-center"><i class="fas fa-times-circle"></i> Error al consultar el estado del cliente.</div>';
            camposForm.style.display = 'none';
        });
});
</script>

<!-- SweetAlert para feedback -->
<script>
<?php if (!empty($success)): ?>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '<?= $success ?>',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = 'creditos.php';
    });
<?php elseif (!empty($error)): ?>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '<?= $error ?>'
    });
<?php endif; ?>
</script>

</body>
</html>

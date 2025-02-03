<?php
// Configuración de la página
$pageTitle = "Registrar Nuevo Crédito";

// Inicia la sesión si aún no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
include '../database/db.php';

// Variables para mensajes
$error = '';
$success = '';

// Obtener la lista de clientes
$sqlClientes = "SELECT id, nombre FROM clientes ORDER BY nombre ASC";
$stmtClientes = $pdo->prepare($sqlClientes);
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de asesores (solo los activos)
$sqlAsesores = "SELECT id, nombre FROM asesores WHERE estado = 'activo' ORDER BY nombre ASC";
$stmtAsesores = $pdo->prepare($sqlAsesores);
$stmtAsesores->execute();
$asesores = $stmtAsesores->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente'] ?? '';
    $asesor_id = $_POST['asesor'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_termino = $_POST['fecha_termino'] ?? '';
    $importe = $_POST['importe'] ?? '';

    // Validación de campos vacíos
    if (empty($cliente_id) || empty($asesor_id) || empty($fecha_inicio) || empty($fecha_termino) || empty($importe)) {
        $error = 'Por favor, complete todos los campos.';
    } else {
        // Insertar en la base de datos
        try {
            $sql = "INSERT INTO creditos (cliente_id, asesor_id, fecha_inicio, fecha_termino, importe) 
                    VALUES (:cliente_id, :asesor_id, :fecha_inicio, :fecha_termino, :importe)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':asesor_id' => $asesor_id,
                ':fecha_inicio' => $fecha_inicio,
                ':fecha_termino' => $fecha_termino,
                ':importe' => $importe,
            ]);
            $success = "Crédito registrado con éxito.";
        } catch (PDOException $e) {
            $error = 'Error al registrar el crédito: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4"><i class="fas fa-money-check-alt"></i> Registrar Nuevo Crédito</h1>
    <div class="form-container">
        <form method="POST">
            <!-- Cliente -->
            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente</label>
                <select class="form-select" id="cliente" name="cliente" required>
                    <option value="">Selecciona un cliente</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>
                <div class="col-md-6">
                    <label for="fecha_termino" class="form-label">Fecha de Término</label>
                    <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="importe" class="form-label">Importe</label>
                    <input type="number" class="form-control" id="importe" name="importe" step="0.01" required>
                </div>
            </div>
            <!-- Asesor -->
            <div class="mb-3">
                <label for="asesor" class="form-label">Asesor</label>
                <select class="form-select" id="asesor" name="asesor" required>
                    <option value="">Selecciona un asesor</option>
                    <?php foreach ($asesores as $asesor): ?>
                        <option value="<?= $asesor['id'] ?>"><?= htmlspecialchars($asesor['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100"><i class="fas fa-save"></i> Registrar Crédito</button>
            <a href="javascript:history.back()" class="btn btn-secondary w-100 mt-3">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </form>
    </div>
</div>

<!-- SweetAlert2 -->
<script>
    <?php if (!empty($success)): ?>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '<?php echo $success; ?>',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'creditos.php';
        });
    <?php elseif (!empty($error)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo $error; ?>'
        });
    <?php endif; ?>
</script>

</body>
</html>

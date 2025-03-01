<?php
// Configuración de la página
$pageTitle = "Registrar Nuevo Cliente";

// Inicia la sesión si aún no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
include '../database/db.php';

// Variables para mensajes
$error = '';
$success = '';

// Procesar el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $giro_negocio = trim($_POST['giro_negocio'] ?? '');
    $tipo_producto = trim($_POST['tipo_producto'] ?? '');
    $ubicacion_google_maps = trim($_POST['ubicacion_google_maps'] ?? '');

    // Validar que todos los campos obligatorios están completos
    if (empty($nombre) || empty($direccion) || empty($telefono) || empty($giro_negocio) || empty($tipo_producto) || empty($ubicacion_google_maps)) {
        $error = 'Por favor, complete todos los campos obligatorios.';
    } else {
        // Validar si el cliente ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE nombre = :nombre");
        $stmt->execute([':nombre' => $nombre]);
        $clienteExiste = $stmt->fetchColumn();

        if ($clienteExiste > 0) {
            $error = "El cliente con este nombre ya está registrado.";
        } else {
            // Procesar la foto subida
            $foto_local = '';
            if (isset($_FILES['foto_local']) && $_FILES['foto_local']['error'] === UPLOAD_ERR_OK) {
                $foto_nombre = uniqid() . '_' . basename($_FILES['foto_local']['name']);
                $foto_ruta = '../img/clientes/' . $foto_nombre;

                if (move_uploaded_file($_FILES['foto_local']['tmp_name'], $foto_ruta)) {
                    $foto_local = $foto_nombre;
                } else {
                    $error = 'Error al subir la foto del local.';
                }
            }

            // Insertar datos en la base de datos si no hay errores
            if (empty($error)) {
                try {
                    $sql = "INSERT INTO clientes (nombre, direccion, telefono, giro_negocio, tipo_producto, foto_local, ubicacion_google_maps) 
                            VALUES (:nombre, :direccion, :telefono, :giro_negocio, :tipo_producto, :foto_local, :ubicacion_google_maps)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':nombre' => $nombre,
                        ':direccion' => $direccion,
                        ':telefono' => $telefono,
                        ':giro_negocio' => $giro_negocio,
                        ':tipo_producto' => $tipo_producto,
                        ':foto_local' => $foto_local,
                        ':ubicacion_google_maps' => $ubicacion_google_maps
                    ]);

                    $success = "Cliente registrado con éxito.";
                } catch (PDOException $e) {
                    $error = 'Error al registrar el cliente: ' . $e->getMessage();
                }
            }
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
    <link rel="shortcut icon" href="../img/cimeli.png" type="image/x-icon">
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
    <h1 class="text-center mb-4"><i class="fas fa-user-plus"></i> Registrar Nuevo Cliente</h1>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre del Cliente</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre completo" required>
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el número de teléfono" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese la dirección" required>
                </div>
                <div class="col-md-4">
                    <label for="giro_negocio" class="form-label">Giro del Negocio</label>
                    <input type="text" name="giro_negocio" id="giro_negocio" class="form-control" placeholder="Giro del negocio" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipo_producto" class="form-label">Tipo de Producto</label>
                    <input type="text" name="tipo_producto" id="tipo_producto" class="form-control" placeholder="Tipo de producto" required>
                </div>
                <div class="col-md-6">
                    <label for="foto_local" class="form-label">Foto del Local</label>
                    <input type="file" name="foto_local" id="foto_local" class="form-control" accept="image/*" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="ubicacion_google_maps" class="form-label">Ubicación de Google Maps</label>
                    <input type="url" name="ubicacion_google_maps" id="ubicacion_google_maps" class="form-control" placeholder="https://maps.google.com/..." required>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrar Cliente</button>
            <a href="javascript:history.back()" class="btn btn-secondary w-100 mt-3">
                <i class="fas fa-arrow-left"></i> Volver a la página anterior
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
            window.location.href = 'clientes.php';
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

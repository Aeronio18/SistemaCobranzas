<?php
$pageTitle = "Registrar Cliente";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../database/db.php';

$error = '';
$success = '';

// Obtener lista de asesores
$sqlAsesores = "SELECT id, nombre FROM asesores WHERE estado = 'activo' ORDER BY nombre ASC";
$stmtAsesores = $pdo->prepare($sqlAsesores);
$stmtAsesores->execute();
$asesores = $stmtAsesores->fetchAll(PDO::FETCH_ASSOC);

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Subir foto local
        $foto_local = '';
        if (isset($_FILES['foto_local']) && $_FILES['foto_local']['error'] === UPLOAD_ERR_OK) {
            $foto_nombre = uniqid() . '_' . basename($_FILES['foto_local']['name']);
            $foto_ruta = '../img/clientes/' . $foto_nombre;
            if (move_uploaded_file($_FILES['foto_local']['tmp_name'], $foto_ruta)) {
                $foto_local = $foto_nombre;
            } else {
                throw new Exception('Error al subir la foto.');
            }
        }

        // Insertar cliente
        $sqlCliente = "INSERT INTO clientes (
            nombre, direccion, telefono, giro_negocio, tipo_producto,
            foto_local, ubicacion_google_maps,
            fecha_nacimiento, lugar_nacimiento, estado_civil, sexo,
            colonia, municipio, estado, codigo_postal, nss, curp, escolaridad,
            ocupacion, lugar_trabajo,
            nombre_negocio, negocio_domicilio, negocio_municipio, negocio_estado,
            negocio_codigo_postal, negocio_antiguedad, negocio_rfc, negocio_telefono,
            negocio_ingreso_mensual,
            conyuge_nombre, conyuge_fecha_nacimiento, conyuge_telefono, conyuge_ocupacion,
            conyuge_lugar_trabajo, conyuge_ingreso_mensual,
            ref_fam_nombre, ref_fam_parentesco, ref_fam_telefono, ref_fam_domicilio,
            ref_fam_colonia, ref_fam_municipio, ref_fam_estado, ref_fam_codigo_postal,
            ref_no_fam_nombre, ref_no_fam_parentesco, ref_no_fam_telefono, ref_no_fam_domicilio,
            ref_no_fam_colonia, ref_no_fam_municipio, ref_no_fam_estado, ref_no_fam_codigo_postal
        ) VALUES (
            :nombre, :direccion, :telefono, :giro_negocio, :tipo_producto,
            :foto_local, :ubicacion_google_maps,
            :fecha_nacimiento, :lugar_nacimiento, :estado_civil, :sexo,
            :colonia, :municipio, :estado, :codigo_postal, :nss, :curp, :escolaridad,
            :ocupacion, :lugar_trabajo,
            :nombre_negocio, :negocio_domicilio, :negocio_municipio, :negocio_estado,
            :negocio_codigo_postal, :negocio_antiguedad, :negocio_rfc, :negocio_telefono,
            :negocio_ingreso_mensual,
            :conyuge_nombre, :conyuge_fecha_nacimiento, :conyuge_telefono, :conyuge_ocupacion,
            :conyuge_lugar_trabajo, :conyuge_ingreso_mensual,
            :ref_fam_nombre, :ref_fam_parentesco, :ref_fam_telefono, :ref_fam_domicilio,
            :ref_fam_colonia, :ref_fam_municipio, :ref_fam_estado, :ref_fam_codigo_postal,
            :ref_no_fam_nombre, :ref_no_fam_parentesco, :ref_no_fam_telefono, :ref_no_fam_domicilio,
            :ref_no_fam_colonia, :ref_no_fam_municipio, :ref_no_fam_estado, :ref_no_fam_codigo_postal
        )";

        $stmtCliente = $pdo->prepare($sqlCliente);
        $paramsCliente = [
            'nombre' => $_POST['nombre'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'giro_negocio' => $_POST['giro_negocio'] ?? '',
            'tipo_producto' => $_POST['tipo_producto'] ?? '',
            'foto_local' => $foto_local,
            'ubicacion_google_maps' => $_POST['ubicacion_google_maps'] ?? '',

            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
            'lugar_nacimiento' => $_POST['lugar_nacimiento'] ?? '',
            'estado_civil' => $_POST['estado_civil'] ?? '',
            'sexo' => $_POST['sexo'] ?? '',
            'colonia' => $_POST['colonia'] ?? '',
            'municipio' => $_POST['municipio'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'codigo_postal' => $_POST['codigo_postal'] ?? '',
            'nss' => $_POST['nss'] ?? '',
            'curp' => $_POST['curp'] ?? '',
            'escolaridad' => $_POST['escolaridad'] ?? '',
            'ocupacion' => $_POST['ocupacion'] ?? '',
            'lugar_trabajo' => $_POST['lugar_trabajo'] ?? '',

            'nombre_negocio' => $_POST['nombre_negocio'] ?? '',
            'negocio_domicilio' => $_POST['negocio_domicilio'] ?? '',
            'negocio_municipio' => $_POST['negocio_municipio'] ?? '',
            'negocio_estado' => $_POST['negocio_estado'] ?? '',
            'negocio_codigo_postal' => $_POST['negocio_codigo_postal'] ?? '',
            'negocio_antiguedad' => $_POST['negocio_antiguedad'] ?? '',
            'negocio_rfc' => $_POST['negocio_rfc'] ?? '',
            'negocio_telefono' => $_POST['negocio_telefono'] ?? '',
            'negocio_ingreso_mensual' => $_POST['negocio_ingreso_mensual'] ?? 0,

            'conyuge_nombre' => $_POST['conyuge_nombre'] ?? '',
            'conyuge_fecha_nacimiento' => $_POST['conyuge_fecha_nacimiento'] ?? null,
            'conyuge_telefono' => $_POST['conyuge_telefono'] ?? '',
            'conyuge_ocupacion' => $_POST['conyuge_ocupacion'] ?? '',
            'conyuge_lugar_trabajo' => $_POST['conyuge_lugar_trabajo'] ?? '',
            'conyuge_ingreso_mensual' => $_POST['conyuge_ingreso_mensual'] ?? 0,

            'ref_fam_nombre' => $_POST['ref_fam_nombre'] ?? '',
            'ref_fam_parentesco' => $_POST['ref_fam_parentesco'] ?? '',
            'ref_fam_telefono' => $_POST['ref_fam_telefono'] ?? '',
            'ref_fam_domicilio' => $_POST['ref_fam_domicilio'] ?? '',
            'ref_fam_colonia' => $_POST['ref_fam_colonia'] ?? '',
            'ref_fam_municipio' => $_POST['ref_fam_municipio'] ?? '',
            'ref_fam_estado' => $_POST['ref_fam_estado'] ?? '',
            'ref_fam_codigo_postal' => $_POST['ref_fam_codigo_postal'] ?? '',

            'ref_no_fam_nombre' => $_POST['ref_no_fam_nombre'] ?? '',
            'ref_no_fam_parentesco' => $_POST['ref_no_fam_parentesco'] ?? '',
            'ref_no_fam_telefono' => $_POST['ref_no_fam_telefono'] ?? '',
            'ref_no_fam_domicilio' => $_POST['ref_no_fam_domicilio'] ?? '',
            'ref_no_fam_colonia' => $_POST['ref_no_fam_colonia'] ?? '',
            'ref_no_fam_municipio' => $_POST['ref_no_fam_municipio'] ?? '',
            'ref_no_fam_estado' => $_POST['ref_no_fam_estado'] ?? '',
            'ref_no_fam_codigo_postal' => $_POST['ref_no_fam_codigo_postal'] ?? ''
        ];

        $stmtCliente->execute($paramsCliente);

        // Obtener ID del cliente insertado
        $cliente_id = $pdo->lastInsertId();

        // Insertar crédito
        $sqlCredito = "INSERT INTO creditos (
            cliente_id, asesor_id, fecha_inicio, fecha_termino, importe, abono
        ) VALUES (
            :cliente_id, :asesor_id, :fecha_inicio, :fecha_termino, :importe, :abono
        )";

        $stmtCredito = $pdo->prepare($sqlCredito);
        $paramsCredito = [
            'cliente_id' => $cliente_id,
            'asesor_id' => $_POST['asesor_id'] ?? 0,
            'fecha_inicio' => $_POST['fecha_inicio'] ?? null,
            'fecha_termino' => $_POST['fecha_termino'] ?? null,
            'importe' => $_POST['importe'] ?? 0,
            'abono' => $_POST['abono'] ?? 0
        ];

        $stmtCredito->execute($paramsCredito);

        $pdo->commit();
        $success = "Cliente y crédito registrados exitosamente.";

    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="shortcut icon" href="../img/cimeli.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .input-group-text {
            background-color: #e9ecef;
        }
        label {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4"><i class="fas fa-user-plus"></i> Registrar Cliente y Crédito</h2>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data" class="container mt-4">
  <h4 class="mb-3">Datos Personales</h4>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nombre completo</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="col-md-3 mb-3">
      <label>Fecha de nacimiento</label>
      <input type="date" name="fecha_nacimiento" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Lugar de nacimiento</label>
      <input type="text" name="lugar_nacimiento" class="form-control">
    </div>
  </div>
  <div class="row">
    <div class="col-md-3 mb-3">
      <label>Estado civil</label>
      <select name="estado_civil" class="form-control">
        <option value="">Seleccione</option>
        <option>Soltero</option>
        <option>Casado</option>
        <option>Divorciado</option>
        <option>Viudo</option>
      </select>
    </div>
    <div class="col-md-3 mb-3">
      <label>Sexo</label>
      <select name="sexo" class="form-control">
        <option value="">Seleccione</option>
        <option>Masculino</option>
        <option>Femenino</option>
        <option>Otro</option>
      </select>
    </div>
    <div class="col-md-3 mb-3">
      <label>NSS</label>
      <input type="text" name="nss" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>CURP</label>
      <input type="text" name="curp" class="form-control">
    </div>
  </div>
  <div class="row">
    <div class="col-md-3 mb-3">
      <label>Escolaridad</label>
      <input type="text" name="escolaridad" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Ocupación</label>
      <input type="text" name="ocupacion" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
      <label>Lugar de trabajo</label>
      <input type="text" name="lugar_trabajo" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Dirección</label>
    <input type="text" name="direccion" class="form-control" required>
  </div>
  <div class="row">
    <div class="col-md-3 mb-3">
      <label>Colonia</label>
      <input type="text" name="colonia" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Municipio</label>
      <input type="text" name="municipio" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Estado</label>
      <input type="text" name="estado" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Código postal</label>
      <input type="text" name="codigo_postal" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Teléfono</label>
    <input type="text" name="telefono" class="form-control" required>
  </div>

  <h4 class="mt-4 mb-3">Datos del Negocio</h4>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nombre del negocio</label>
      <input type="text" name="nombre_negocio" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
      <label>Giro del negocio</label>
      <input type="text" name="giro_negocio" class="form-control" required>
    </div>
  </div>
  <div class="mb-3">
    <label>Domicilio del negocio</label>
    <input type="text" name="negocio_domicilio" class="form-control">
  </div>
  <div class="row">
    <div class="col-md-3 mb-3">
      <label>Municipio</label>
      <input type="text" name="negocio_municipio" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Estado</label>
      <input type="text" name="negocio_estado" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Código postal</label>
      <input type="text" name="negocio_codigo_postal" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Antigüedad</label>
      <input type="text" name="negocio_antiguedad" class="form-control">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 mb-3">
      <label>RFC</label>
      <input type="text" name="negocio_rfc" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
      <label>Teléfono del negocio</label>
      <input type="text" name="negocio_telefono" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
      <label>Ingreso mensual</label>
      <input type="number" step="0.01" name="negocio_ingreso_mensual" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Tipo de producto</label>
    <input type="text" name="tipo_producto" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Foto del local</label>
    <input type="file" name="foto_local" class="form-control">
  </div>
  <div class="mb-3">
    <label>Ubicación Google Maps</label>
    <textarea name="ubicacion_google_maps" class="form-control"></textarea>
  </div>

  <h4 class="mt-4 mb-3">Datos del Cónyuge</h4>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nombre</label>
      <input type="text" name="conyuge_nombre" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Fecha de nacimiento</label>
      <input type="date" name="conyuge_fecha_nacimiento" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Teléfono</label>
      <input type="text" name="conyuge_telefono" class="form-control">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Ocupación</label>
      <input type="text" name="conyuge_ocupacion" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
      <label>Lugar de trabajo</label>
      <input type="text" name="conyuge_lugar_trabajo" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Ingreso mensual</label>
    <input type="number" step="0.01" name="conyuge_ingreso_mensual" class="form-control">
  </div>

  <h4 class="mt-4 mb-3">Referencia Familiar</h4>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nombre</label>
      <input type="text" name="ref_fam_nombre" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
      <label>Parentesco</label>
      <input type="text" name="ref_fam_parentesco" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Domicilio</label>
    <input type="text" name="ref_fam_domicilio" class="form-control">
  </div>
  <div class="row">
    <div class="col-md-3 mb-3">
      <label>Colonia</label>
      <input type="text" name="ref_fam_colonia" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Municipio</label>
      <input type="text" name="ref_fam_municipio" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Estado</label>
      <input type="text" name="ref_fam_estado" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Código postal</label>
      <input type="text" name="ref_fam_codigo_postal" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Teléfono</label>
    <input type="text" name="ref_fam_telefono" class="form-control">
  </div>

  <h4 class="mt-4 mb-3">Referencia No Familiar</h4>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nombre</label>
      <input type="text" name="ref_no_fam_nombre" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
      <label>Parentesco</label>
      <input type="text" name="ref_no_fam_parentesco" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Domicilio</label>
    <input type="text" name="ref_no_fam_domicilio" class="form-control">
  </div>
  <div class="row">
    <div class="col-md-3 mb-3">
      <label>Colonia</label>
      <input type="text" name="ref_no_fam_colonia" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Municipio</label>
      <input type="text" name="ref_no_fam_municipio" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Estado</label>
      <input type="text" name="ref_no_fam_estado" class="form-control">
    </div>
    <div class="col-md-3 mb-3">
      <label>Código postal</label>
      <input type="text" name="ref_no_fam_codigo_postal" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Teléfono</label>
    <input type="text" name="ref_no_fam_telefono" class="form-control">
  </div>

  <h4 class="mt-4 mb-3">Datos del Crédito</h4>
  <div class="row">
    <div class="col-md-4 mb-3">
      <label>Asesor</label>
      <select name="asesor_id" class="form-control">
        <option value="">Seleccione</option>
        <?php foreach ($asesores as $asesor): ?>
          <option value="<?= $asesor['id'] ?>"><?= htmlspecialchars($asesor['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 mb-3">
      <label>Fecha de inicio</label>
      <input type="date" name="fecha_inicio" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
      <label>Fecha de término</label>
      <input type="date" name="fecha_termino" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Importe</label>
    <input type="number" step="0.01" name="importe" class="form-control">
  </div>

  <div class="d-flex justify-content-center mt-4">
  <button type="submit" class="btn btn-primary me-2">
    <i class="fas fa-save"></i> Registrar Cliente
  </button>
  <a href="javascript:history.back()" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
</div>
</form>
    </div>
</div>

<script>
<?php if (!empty($success)): ?>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '<?php echo $success; ?>',
        timer: 2500,
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

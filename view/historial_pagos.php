<?php
// Incluir la conexión a la base de datos
include '../database/db.php';

// Verificar si se pasó un ID de crédito
if (!isset($_GET['credito_id'])) {
    die("Crédito no especificado.");
}

$credito_id = $_GET['credito_id'];

try {
    // Consulta para obtener el historial de pagos junto con el asesor asignado
    $query = "SELECT p.monto, p.fecha_pago, p.metodo_pago, a.nombre AS nombre_asesor
              FROM pagos p
              JOIN creditos c ON p.credito_id = c.id
              JOIN asesores a ON c.asesor_id = a.id
              WHERE p.credito_id = :credito_id
              LIMIT 1";  // Solo necesitamos un resultado para el asesor
              
    $stmt = $pdo->prepare($query);
    $stmt->execute(['credito_id' => $credito_id]);

    // Verificar si hay datos
    $asesor = "No asignado"; // Valor por defecto si no hay asesor
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $asesor = htmlspecialchars($row['nombre_asesor']);
    }
} catch (PDOException $e) {
    die("Error al obtener la información: " . $e->getMessage());
}

// Consulta para obtener los pagos del crédito con latitud y longitud
try {
    $queryPagos = "SELECT monto, fecha_pago, metodo_pago, latitud, longitud FROM pagos WHERE credito_id = :credito_id";
    $stmtPagos = $pdo->prepare($queryPagos);
    $stmtPagos->execute(['credito_id' => $credito_id]);

    $pagosRows = '';
    if ($stmtPagos->rowCount() > 0) {
        while ($pago = $stmtPagos->fetch(PDO::FETCH_ASSOC)) {
            $pagosRows .= '
            <tr>
                <td>$' . number_format($pago['monto'], 2) . '</td>
                <td>' . date('d/m/Y', strtotime($pago['fecha_pago'])) . '</td>
                <td>' . htmlspecialchars($pago['metodo_pago']) . '</td>
                <td>';
            if (!empty($pago['latitud']) && !empty($pago['longitud'])) {
                $lat = $pago['latitud'];
                $lng = $pago['longitud'];
                $urlMaps = "https://www.google.com/maps?q={$lat},{$lng}";
                $pagosRows .= '
                <a href="' . $urlMaps . '" target="_blank" rel="noopener noreferrer" 
                   class="btn btn-sm btn-primary btn-maps" title="Ver ubicación en Google Maps">
                    <i class="fas fa-map-marker-alt me-1"></i> Ver ubicación
                </a>';
            } else {
                $pagosRows .= 'No disponible';
            }
            $pagosRows .= '</td>
            </tr>';
        }
    } else {
        $pagosRows = '<tr><td colspan="4" class="text-center">No se han registrado pagos para este crédito.</td></tr>';
    }
} catch (PDOException $e) {
    die("Error al obtener los pagos: " . $e->getMessage());
}

// El contenido de la página
$pageTitle = "Historial de Pagos";
$content = '
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history"></i> Historial de Pagos del Crédito</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Monto</th>
                            <th>Fecha de Pago</th>
                            <th>Método de Pago</th>
                            <th>Ubicación</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $pagosRows . '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<a href="javascript:history.back()" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Regresar
</a>
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistrarPago">
    <i class="fas fa-dollar-sign"></i> Registrar Pago
</button>
';

// Modal para Registrar Pago
$content .= '
<div class="modal fade" id="modalRegistrarPago" tabindex="-1" aria-labelledby="modalRegistrarPagoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarPagoLabel">Registrar Pago del Crédito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarPago" action="../models/procesar_pago.php" method="POST">
                    <input type="hidden" name="credito_id" value="' . $credito_id . '">
                    <input type="hidden" id="latitud" name="latitud" value="">
                    <input type="hidden" id="longitud" name="longitud" value="">
                    <div class="mb-3">
                        <label for="monto_pago" class="form-label">Monto del Pago</label>
                        <input type="number" class="form-control" id="monto_pago" name="monto_pago" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                    </div>
                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';

include '../templates/dashboard_layout.php';
?>
<style>
/* Estilos para el botón de ubicación con animación */
.btn-maps {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 5px 10px;
    border-radius: 6px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-size: 14px;
}

.btn-maps:hover {
    background-color: #0d6efd; /* Bootstrap primary hover color */
    color: white;
    transform: scale(1.1) rotate(8deg);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.4);
}
</style>
<script>
document.getElementById('formRegistrarPago').addEventListener('submit', function(event) {
    event.preventDefault();  // Evita el envío inmediato
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // Asignar valores a los campos ocultos
            document.getElementById('latitud').value = position.coords.latitude;
            document.getElementById('longitud').value = position.coords.longitude;
            
            // Enviar el formulario una vez obtenida la ubicación
            event.target.submit();
        }, function(error) {
            // Si hay error o el usuario no da permiso, enviar igual sin ubicación
            console.warn('No se pudo obtener la ubicación, se enviará sin ella.');
            event.target.submit();
        }, {
            timeout: 10000  // Espera hasta 10 segundos para obtener ubicación
        });
    } else {
        // Geolocalización no soportada, enviar sin ubicación
        console.warn('Geolocalización no soportada por este navegador.');
        event.target.submit();
    }
});
</script>

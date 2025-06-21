<?php
$pageTitle = "Corte de Cartera";
ob_start();
// Consulta pagos del día
include '../database/db.php';
date_default_timezone_set('America/Mexico_City');
$hoy = date('Y-m-d');

$queryPagosHoy = "
    SELECT p.monto, p.fecha_pago, p.metodo_pago, c.id AS credito_id
    FROM pagos p
    JOIN creditos c ON p.credito_id = c.id
    WHERE p.fecha_pago = :hoy
";
$stmt = $pdo->prepare($queryPagosHoy);
$stmt->execute(['hoy' => $hoy]);
$pagosHoy = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Consulta desembolsos diarios con campo es_renovacion
$queryDesembolsosHoy = "
    SELECT c.id, cl.nombre AS cliente, c.importe, c.fecha_inicio, c.es_renovacion
    FROM creditos c
    JOIN clientes cl ON c.cliente_id = cl.id
    WHERE DATE(c.fecha_inicio) = :hoy
";
$stmt = $pdo->prepare($queryDesembolsosHoy);
$stmt->execute(['hoy' => $hoy]);
$desembolsosHoy = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-4">
    <h1 class="text-center mb-4"><i class="fas fa-chart-line"></i> Corte de Cartera</h1>

    <!-- TARJETAS PRINCIPALES -->
    <div class="row mb-4">
                <div class="col-md-6 mb-2">
            <div class="card text-bg-success text-center h-100" role="button" onclick="mostrarSeccion('diario')">
                <div class="card-body">
                    <h4><i class="fas fa-calendar-day"></i> Corte Diario</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card text-bg-primary text-center h-100" role="button" onclick="mostrarSeccion('semanal')">
                <div class="card-body">
                    <h4><i class="fas fa-calendar-week"></i> Corte Semanal</h4>
                </div>
            </div>
        </div>
    </div>
<!-- SECCIÓN DIARIA -->
    <div id="seccion_diario" class="d-none">
        <h3 class="text-success mb-3"><i class="fas fa-calendar-day"></i> Detalles Corte Diario</h3>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h5><i class="fas fa-money-check-alt"></i> Cobranza Diaria</h5>
                        <p>Consulta el reporte de la cobranza diaria.</p>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPagosHoy">
                            <i class="fas fa-eye"></i> Ver reporte
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <h5><i class="fas fa-wallet"></i> Desembolso Diario</h5>
                        <p>Consulta el reporte de los desembolsos del día.</p>
                        <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalDesembolsosHoy">
                            <i class="fas fa-eye"></i> Ver reporte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PAGOS HOY -->
<div class="modal fade" id="modalPagosHoy" tabindex="-1" aria-labelledby="modalPagosHoyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-receipt"></i> Pagos Realizados el <?= date('d/m/Y') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php if ($pagosHoy): ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Monto</th>
                <th>Método</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pagosHoy as $pago): ?>
              <tr>
                <td>$<?= number_format($pago['monto'], 2) ?></td>
                <td><?= htmlspecialchars($pago['metodo_pago']) ?></td>
                <td><?= date('d/m/Y', strtotime($pago['fecha_pago'])) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-center text-muted">No se han registrado pagos hoy.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- MODAL DESEMBOLSOS HOY -->
    <div class="modal fade" id="modalDesembolsosHoy" tabindex="-1" aria-labelledby="modalDesembolsosHoyLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-wallet"></i> Desembolsos Realizados el <?= date('d/m/Y') ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
    <?php if ($desembolsosHoy): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Importe</th>
                    <th>Fecha Inicio</th>
                    <th>Renovación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($desembolsosHoy as $desembolso): ?>
                <tr>
                    <td><?= htmlspecialchars($desembolso['cliente']) ?></td>
                    <td>$<?= number_format($desembolso['importe'], 2) ?></td>
                    <td><?= date('d/m/Y', strtotime($desembolso['fecha_inicio'])) ?></td>
                    <td><?= $desembolso['es_renovacion'] ? 'Sí' : 'No' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-muted">No se han registrado desembolsos hoy.</p>
    <?php endif; ?>
</div>
            </div>
        </div>
    </div>
    <!-- SECCIÓN SEMANAL -->
    <div id="seccion_semanal" class="d-none">
        <h3 class="text-primary mb-3"><i class="fas fa-calendar-week"></i> Detalles Corte Semanal</h3>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5><i class="fas fa-dollar-sign"></i> Movimiento de Cartera ($)</h5>
                        <p>Consulta y exporta el reporte del movimiento de cartera en dinero.</p>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-danger"><i class="fas fa-file-pdf"></i> PDF</button>
                            <button class="btn btn-success"><i class="fas fa-file-excel"></i> XLS</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5><i class="fas fa-users"></i> Movimiento Cartera (Clientes)</h5>
                        <p>Consulta el reporte del movimiento de cartera en número de clientes.</p>
                        <a href="#" class="btn btn-primary">Ver reporte</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h5><i class="fas fa-hand-holding-usd"></i> Cobranza Semanal</h5>
                        <p>Consulta el reporte de la cobranza semanal.</p>
                        <a href="#" class="btn btn-success">Ver reporte</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <h5><i class="fas fa-wallet"></i> Desembolso Semanal</h5>
                        <p>Consulta el reporte de los desembolsos de la semana.</p>
                        <a href="#" class="btn btn-warning text-white">Ver reporte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarSeccion(seccion) {
    document.getElementById('seccion_semanal').classList.add('d-none');
    document.getElementById('seccion_diario').classList.add('d-none');

    if (seccion === 'semanal') {
        document.getElementById('seccion_semanal').classList.remove('d-none');
    } else if (seccion === 'diario') {
        document.getElementById('seccion_diario').classList.remove('d-none');
    }
}
</script>
<script>
function mostrarSeccion(seccion) {
    document.getElementById('seccion_semanal').classList.add('d-none');
    document.getElementById('seccion_diario').classList.add('d-none');

    if (seccion === 'semanal') {
        document.getElementById('seccion_semanal').classList.remove('d-none');
    } else if (seccion === 'diario') {
        document.getElementById('seccion_diario').classList.remove('d-none');
    }
}
</script>
<?php
$content = ob_get_clean();
include '../templates/dashboard_layout.php';
?>

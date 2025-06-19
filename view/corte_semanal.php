<?php
$pageTitle = "Corte semanal";
ob_start(); // Iniciamos el buffer para el contenido dinámico
?>

<div class="container mt-3">
    <h1 class="text-center mb-4"><i class="fas fa-calendar-week"></i> Corte semanal</h1>

    <!-- Cierre semanal -->
    <div class="section-title"><i class="fas fa-times-circle"></i> Cierre semanal</div>
    <div class="row">
        <div class="col-md-6">
            <div class="card border-primary">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-dollar-sign"></i> Movimiento de cartera ($)</h5>
        <p class="card-text">Consulta y exporta el reporte del movimiento de cartera en dinero.</p>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="submit" name="export_type" value="pdf" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </button>
                <button type="submit" name="export_type" value="xls" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Exportar XLS
                </button>
            </div>
    </div>
</div>

        </div>
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Movimiento de cartera (clientes)</h5>
                    <p class="card-text">Consulta el reporte del movimiento de cartera en número de clientes.</p>
                    <a href="#" class="btn btn-primary">Ver reporte</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cobranza semanal -->
    <div class="section-title"><i class="fas fa-hand-holding-usd"></i> Cobranza semanal</div>
    <div class="row">
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-money-check-alt"></i> Cobranza semanal</h5>
                    <p class="card-text">Consulta el reporte de la cobranza realizada esta semana.</p>
                    <a href="#" class="btn btn-success">Ver reporte</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-hand-holding"></i> Desembolso semanal</h5>
                    <p class="card-text">Consulta el reporte de desembolsos de la semana.</p>
                    <a href="#" class="btn btn-success">Ver reporte</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Desembolsos -->
    <div class="section-title"><i class="fas fa-wallet"></i> Desembolsos</div>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-hand-holding-usd"></i> Desembolso semanal</h5>
                    <p class="card-text">Revisa el total de desembolsos de esta semana.</p>
                    <a href="#" class="btn btn-warning text-white">Ver reporte</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-plus"></i> Desembolso clientes nuevos</h5>
                    <p class="card-text">Revisa los desembolsos realizados a clientes nuevos.</p>
                    <a href="#" class="btn btn-warning text-white">Ver reporte</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-redo-alt"></i> Desembolso clientes renovados</h5>
                    <p class="card-text">Revisa los desembolsos realizados a clientes renovados.</p>
                    <a href="#" class="btn btn-warning text-white">Ver reporte</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../templates/dashboard_layout.php'; // Incluimos el layout con el contenido dinámico
?>

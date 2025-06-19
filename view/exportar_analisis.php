<?php
require_once '../database/db.php'; // Conexión a tu base de datos

$formato = $_GET['formato'] ?? 'excel';

// Consulta: Análisis de asesores activos
$query = "
SELECT a.nombre AS asesor, COUNT(c.id) AS total_creditos,
       SUM(IF(p.credito_id IS NOT NULL, 1, 0)) AS total_cobrados
FROM asesores a
LEFT JOIN creditos c ON a.id = c.asesor_id
LEFT JOIN pagos p ON c.id = p.credito_id AND p.fecha_pago IS NOT NULL
WHERE a.estado = 'activo'
GROUP BY a.id
";
$data = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

if ($formato === 'pdf') {
    generarPDF($data);
} else {
    generarExcel($data);
    exit;
}

// --------------------------------------------
// ✅ FUNCIÓN: Generar Excel con SimpleXLSXGen
function generarExcel($data) {
    require_once '../lib/SimpleXLSXGen.php';

    $rows = [['Asesor', 'Total Créditos', 'Total Cobrados', 'Avance (%)']];
    foreach ($data as $item) {
        $avance = ($item['total_creditos'] > 0)
            ? ($item['total_cobrados'] / $item['total_creditos']) * 100
            : 0;

        $rows[] = [
            $item['asesor'],
            $item['total_creditos'],
            $item['total_cobrados'],
            round($avance, 2)
        ];
    }

    \Shuchkin\SimpleXLSXGen::fromArray($rows)->downloadAs('analisis_semanal.xlsx');
}

// --------------------------------------------
// ✅ FUNCIÓN: Generar PDF con TCPDF
function generarPDF($data) {
    require_once '../lib/tcpdf/tcpdf.php';

    $pdf = new TCPDF();
    $pdf->SetCreator('Sistema');
    $pdf->SetAuthor('Sistema de Créditos');
    $pdf->SetTitle('Análisis Semanal');
    $pdf->AddPage();

    $html = '<h2 style="text-align:center;">Análisis Semanal de Asesores</h2>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th><strong>Asesor</strong></th>
                <th><strong>Total Créditos</strong></th>
                <th><strong>Total Cobrados</strong></th>
                <th><strong>Avance (%)</strong></th>
            </tr>
        </thead>
        <tbody>';

    foreach ($data as $item) {
        $avance = ($item['total_creditos'] > 0)
            ? ($item['total_cobrados'] / $item['total_creditos']) * 100
            : 0;

        $html .= '<tr>
            <td>' . htmlspecialchars($item['asesor']) . '</td>
            <td>' . $item['total_creditos'] . '</td>
            <td>' . $item['total_cobrados'] . '</td>
            <td>' . round($avance, 2) . '%</td>
        </tr>';
    }

    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('analisis_semanal.pdf', 'E'); // Descargar
    exit;
}
// --------------------------------------------
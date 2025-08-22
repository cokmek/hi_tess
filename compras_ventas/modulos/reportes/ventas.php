<?php
require_once '../../includes/conexion.php';

$desde = $_GET['desde'] ?? date('Y-m-d');
$hasta = $_GET['hasta'] ?? date('Y-m-d');

$stmt = $pdo->prepare("
    SELECT v.id, v.fecha, c.nombre AS cliente, v.total 
    FROM ventas v
    JOIN clientes c ON v.cliente_id = c.id
    WHERE fecha BETWEEN ? AND ?
    ORDER BY v.fecha DESC
");
$stmt->execute([$desde, $hasta]);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($ventas) === 0) {
    echo "<tr><td colspan='5' class='text-center'>No se encontraron ventas en este rango</td></tr>";
} else {
    foreach ($ventas as $venta) {
        echo "<tr>
                <td>{$venta['id']}</td>
                <td>{$venta['fecha']}</td>
                <td>{$venta['cliente']}</td>
                <td>$" . number_format($venta['total'], 2) . "</td>
                <td>
                    <button class='btn btn-info btn-sm btnVerDetalle' data-id='{$venta['id']}'>Ver</button>
                </td>
              </tr>";
    }
}


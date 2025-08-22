<?php
require_once '../../includes/conexion.php';

$desde = $_GET['desde'] ?? date('Y-m-d');
$hasta = $_GET['hasta'] ?? date('Y-m-d');

$stmt = $pdo->prepare("
    SELECT c.id, c.fecha, c.total, p.nombre AS proveedor 
    FROM compras c
    JOIN proveedores p ON c.proveedor_id = p.id
    WHERE fecha BETWEEN ? AND ?
    ORDER BY c.fecha DESC
");
$stmt->execute([$desde, $hasta]);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($compras) === 0) {
    echo "<tr><td colspan='5' class='text-center'>No se encontraron compras en este rango</td></tr>";
} else {
    foreach ($compras as $compra) {
        echo "<tr>
                <td>{$compra['id']}</td>
                <td>{$compra['fecha']}</td>
                <td>{$compra['proveedor']}</td>
                <td>$" . number_format($compra['total'], 2) . "</td>
                <td>
                    <button class='btn btn-info btn-sm btnVerDetalleCompra' data-id='{$compra['id']}'>Ver</button>
                </td>
              </tr>";
    }
}

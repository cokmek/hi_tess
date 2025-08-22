<?php
require_once '../../includes/conexion.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<div class='alert alert-danger'>ID inválido</div>";
    exit;
}

$stmt = $pdo->prepare("SELECT v.*, c.nombre as cliente FROM ventas v JOIN clientes c ON v.cliente_id = c.id WHERE v.id = ?");
$stmt->execute([$id]);
$venta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$venta) {
    echo "<div class='alert alert-danger'>Venta no encontrada</div>";
    exit;
}

echo "<strong>Cliente:</strong> " . htmlspecialchars($venta['cliente']) . "<br>";
echo "<strong>Fecha:</strong> " . htmlspecialchars($venta['fecha']) . "<br>";
echo "<strong>Total:</strong> $" . number_format($venta['total'], 2) . "<br><br>";

echo "<table class='table table-bordered'><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr></thead><tbody>";

$stmt = $pdo->prepare("SELECT d.*, p.nombre FROM detalle_ventas d JOIN productos p ON d.producto_id = p.id WHERE d.venta_id = ?");
$stmt->execute([$id]);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $subtotal = $row['cantidad'] * $row['precio_venta'];
    echo "<tr>
        <td>" . htmlspecialchars($row['nombre']) . "</td>
        <td>" . intval($row['cantidad']) . "</td>
        <td>$" . number_format($row['precio_venta'], 2) . "</td>
        <td>$" . number_format($subtotal, 2) . "</td>
    </tr>";
}
echo "</tbody></table>";
?>

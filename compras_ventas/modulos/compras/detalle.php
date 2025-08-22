
<?php
require_once "../../includes/conexion.php";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<div class='alert alert-danger'>ID inválido</div>";
    exit;
}

$stmt = $pdo->prepare("SELECT c.*, p.nombre as proveedor FROM compras c JOIN proveedores p ON c.proveedor_id = p.id WHERE c.id = ?");
$stmt->execute([$id]);
$compra = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$compra) {
    echo "<div class='alert alert-danger'>Compra no encontrada</div>";
    exit;
}

echo "<strong>Proveedor:</strong> " . htmlspecialchars($compra['proveedor']) . "<br>";
echo "<strong>Fecha:</strong> " . htmlspecialchars($compra['fecha']) . "<br>";
echo "<strong>Total:</strong> $" . number_format($compra['total'], 2) . "<br><br>";

echo "<table class='table table-bordered'><thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr></thead><tbody>";

$stmt = $pdo->prepare("SELECT d.*, pr.nombre FROM compras_detalle d JOIN productos pr ON d.producto_id = pr.id WHERE d.compra_id = ?");
$stmt->execute([$id]);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $subtotal = $row['cantidad'] * $row['precio'];
    echo "<tr>
        <td>" . htmlspecialchars($row['nombre']) . "</td>
        <td>" . intval($row['cantidad']) . "</td>
        <td>$" . number_format($row['precio'], 2) . "</td>
        <td>$" . number_format($subtotal, 2) . "</td>
    </tr>";
}
echo "</tbody></table>";
?>
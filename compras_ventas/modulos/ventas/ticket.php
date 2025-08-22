<?php
require_once '../../includes/conexion.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT v.id, v.fecha, v.total, c.nombre AS cliente
    FROM ventas v
    JOIN clientes c ON v.cliente_id = c.id
    WHERE v.id = ?
");
$stmt->execute([$id]);
$venta = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtDetalle = $pdo->prepare("
    SELECT p.nombre, dv.cantidad, dv.precio_venta
    FROM detalle_ventas dv
    JOIN productos p ON dv.producto_id = p.id
    WHERE dv.venta_id = ?
");
$stmtDetalle->execute([$id]);
$detalle = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

if (!$venta) {
    echo "Venta no encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Ticket de Venta #<?= htmlspecialchars($venta['id']) ?></title>
<style>
  body {
    font-family: monospace;
    width: 250px;
    margin: 0 auto;
  }
  h3 {
    text-align: center;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
  }
  th, td {
    border-bottom: 1px dotted #000;
    padding: 4px 2px;
  }
  th {
    text-align: left;
  }
  td.centro {
    text-align: center;
  }
  td.derecha {
    text-align: right;
  }
  p.total {
    text-align: right;
    font-weight: bold;
    margin-top: 10px;
    font-size: 14px;
  }
  p.gracias {
    text-align: center;
    margin-top: 15px;
  }
</style>
<script>
  window.onload = function() {
    window.print();
    setTimeout(function() {
      window.close();
    }, 100);
  };
</script>
</head>
<body>
    <h3>Ticket de Venta</h3>
    <p><strong>Fecha:</strong> <?= htmlspecialchars($venta['fecha']) ?></p>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($venta['cliente']) ?></p>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="centro">Cant</th>
                <th class="derecha">Precio</th>
                <th class="derecha">Subt</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalle as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nombre']) ?></td>
                <td class="centro"><?= (int)$item['cantidad'] ?></td>
                <td class="derecha"><?= number_format($item['precio_venta'], 2) ?></td>
                <td class="derecha"><?= number_format($item['cantidad'] * $item['precio_venta'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p class="total">TOTAL: $<?= number_format($venta['total'], 2) ?></p>
    <p class="gracias">Gracias por su compra</p>
</body>
</html>

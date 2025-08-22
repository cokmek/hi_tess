<?php
require_once '../../includes/conexion.php';

$desde = $_GET['desde'] ?? date('Y-m-d');
$hasta = $_GET['hasta'] ?? date('Y-m-d');

// Totales
$stmtTotal = $pdo->prepare("
    SELECT SUM(total) as total_comprado, COUNT(*) as cantidad 
    FROM compras 
    WHERE fecha BETWEEN ? AND ?
");
$stmtTotal->execute([$desde, $hasta]);
$resumen = $stmtTotal->fetch(PDO::FETCH_ASSOC);

// Listado
$stmt = $pdo->prepare("
    SELECT c.id, c.fecha, c.total, p.nombre AS proveedor 
    FROM compras c
    JOIN proveedores p ON c.proveedor_id = p.id
    WHERE fecha BETWEEN ? AND ?
    ORDER BY c.fecha DESC
");
$stmt->execute([$desde, $hasta]);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
    <title>Reporte de Compras</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; margin-bottom: 5px; }
        .resumen { text-align: center; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>📦 Reporte de Compras</h2>
    <div class="resumen">
        <p><strong>Desde:</strong> <?= $desde ?> — <strong>Hasta:</strong> <?= $hasta ?></p>
        <p><strong>Total comprado:</strong> $<?= number_format($resumen['total_comprado'], 2) ?> | 
           <strong>Cantidad de compras:</strong> <?= $resumen['cantidad'] ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($compras) === 0): ?>
                <tr><td colspan="4">No se encontraron compras</td></tr>
            <?php else: ?>
                <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td><?= $compra['id'] ?></td>
                        <td><?= $compra['fecha'] ?></td>
                        <td><?= $compra['proveedor'] ?></td>
                        <td>$<?= number_format($compra['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
<script>
    window.onload = function() {
        window.print();
        // Si quieres cerrar la ventana después de imprimir, descomenta la línea siguiente:
        // window.onafterprint = () => window.close();
    };
</script>
</html>


<?php
require_once '../../includes/conexion.php';

$desde = $_GET['desde'] ?? date('Y-m-d');
$hasta = $_GET['hasta'] ?? date('Y-m-d');

// Totales
$stmtTotal = $pdo->prepare("
    SELECT SUM(total) as total_vendido, COUNT(*) as cantidad 
    FROM ventas 
    WHERE fecha BETWEEN ? AND ?
");
$stmtTotal->execute([$desde, $hasta]);
$resumen = $stmtTotal->fetch(PDO::FETCH_ASSOC);

// Listado
$stmt = $pdo->prepare("
    SELECT v.id, v.fecha, v.total, c.nombre AS cliente 
    FROM ventas v
    JOIN clientes c ON v.cliente_id = c.id
    WHERE fecha BETWEEN ? AND ?
    ORDER BY v.fecha DESC
");
$stmt->execute([$desde, $hasta]);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
    <title>Reporte de Ventas</title>
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
    <h2>📊 Reporte de Ventas</h2>
    <div class="resumen">
        <p><strong>Desde:</strong> <?= $desde ?> — <strong>Hasta:</strong> <?= $hasta ?></p>
        <p><strong>Total vendido:</strong> $<?= number_format($resumen['total_vendido'], 2) ?> | 
           <strong>Cantidad de ventas:</strong> <?= $resumen['cantidad'] ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($ventas) === 0): ?>
                <tr><td colspan="4">No se encontraron ventas</td></tr>
            <?php else: ?>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?= $venta['id'] ?></td>
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['cliente'] ?></td>
                        <td>$<?= number_format($venta['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>


//<script>
   // window.onload = function() {
      //  window.print();
        // Si quieres cerrar la ventana después de imprimir, descomenta la línea siguiente:
        // window.onafterprint = () => window.close();
   // };
//</script>
</html>



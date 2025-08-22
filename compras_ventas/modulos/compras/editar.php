<?php
require_once "../../includes/conexion.php";

$id = intval($_POST['id'] ?? 0);
$proveedor_id = intval($_POST['proveedor_id'] ?? 0);
$total = floatval($_POST['total'] ?? 0);
$productos = $_POST['productos'] ?? [];

if (!$id || !$proveedor_id || empty($productos)) {
    echo "Datos inválidos";
    exit;
}

try {
    $pdo->beginTransaction();

    // Obtener detalles antiguos para revertir stock
    $stmtOld = $pdo->prepare("SELECT producto_id, cantidad FROM detalle_compras WHERE compra_id = ?");
    $stmtOld->execute([$id]);
    $detallesAntiguos = $stmtOld->fetchAll(PDO::FETCH_ASSOC);

    $stmtStockRestar = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
    foreach ($detallesAntiguos as $detalle) {
        $stmtStockRestar->execute([$detalle['cantidad'], $detalle['producto_id']]);
    }

    // Actualizar compra
    $stmtUpdate = $pdo->prepare("UPDATE compras SET proveedor_id = ?, total = ? WHERE id = ?");
    $stmtUpdate->execute([$proveedor_id, $total, $id]);

    // Borrar detalles antiguos
    $stmtDeleteDetalles = $pdo->prepare("DELETE FROM detalle_compras WHERE compra_id = ?");
    $stmtDeleteDetalles->execute([$id]);

    // Insertar nuevos detalles y actualizar stock
    $stmtDetalle = $pdo->prepare("INSERT INTO detalle_compras (compra_id, producto_id, cantidad, precio_compra) VALUES (?, ?, ?, ?)");
    $stmtStockSumar = $pdo->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");

    foreach ($productos as $p) {
        $producto_id = intval($p['producto_id']);
        $cantidad = intval($p['cantidad']);

        // Obtener precio_compra actual
        $stmtPrecio = $pdo->prepare("SELECT precio_compra FROM productos WHERE id = ?");
        $stmtPrecio->execute([$producto_id]);
        $rowPrecio = $stmtPrecio->fetch(PDO::FETCH_ASSOC);
        $precio_compra = $rowPrecio['precio_compra'] ?? 0;

        $stmtDetalle->execute([$id, $producto_id, $cantidad, $precio_compra]);
        $stmtStockSumar->execute([$cantidad, $producto_id]);
    }

    $pdo->commit();
    echo "ok";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}

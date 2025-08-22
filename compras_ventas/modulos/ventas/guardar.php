<?php
header('Content-Type: application/json');
require_once '../../includes/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['cliente_id'], $data['fecha'], $data['total'], $data['productos'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Guardar venta
    $stmt = $pdo->prepare("INSERT INTO ventas (cliente_id, fecha, total) VALUES (?, ?, ?)");
    $stmt->execute([$data['cliente_id'], $data['fecha'], $data['total']]);
    $ventaId = $pdo->lastInsertId(); // ID de la venta

    // Guardar detalle de venta
    $stmtDetalle = $pdo->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_venta) VALUES (?, ?, ?, ?)");
    foreach ($data['productos'] as $prod) {
        $stmtDetalle->execute([$ventaId, $prod['producto_id'], $prod['cantidad'], $prod['precio_venta']]);

        // Actualizar stock
        $stmtStock = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $stmtStock->execute([$prod['cantidad'], $prod['producto_id']]);
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'venta_id' => $ventaId
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

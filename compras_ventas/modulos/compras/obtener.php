<?php
require_once "../../includes/conexion.php";

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    echo json_encode([]);
    exit;
}

// Obtener compra
$stmt = $pdo->prepare("SELECT * FROM compras WHERE id = ?");
$stmt->execute([$id]);
$compra = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$compra) {
    echo json_encode([]);
    exit;
}

// Obtener detalles
$stmtDet = $pdo->prepare("
    SELECT dc.producto_id, dc.cantidad, p.nombre 
    FROM detalle_compras dc 
    JOIN productos p ON dc.producto_id = p.id 
    WHERE dc.compra_id = ?
");
$stmtDet->execute([$id]);
$detalles = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

$compra['detalles'] = $detalles;

header('Content-Type: application/json');
echo json_encode($compra);

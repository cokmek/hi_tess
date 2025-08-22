<?php
require_once '../../includes/conexion.php';

$id = $_POST['id'] ?? 0;

if (!$id) {
    http_response_code(400);
    echo "Falta id";
    exit;
}

$stmt = $pdo->prepare("DELETE FROM proveedores WHERE id = ?");
$result = $stmt->execute([$id]);

if ($result) {
    echo "OK";
} else {
    http_response_code(500);
    echo "Error al eliminar proveedor";
}


// Verifica si el proveedor está en compras
$stmt = $pdo->prepare("SELECT COUNT(*) FROM compras WHERE proveedor_id = ?");
$stmt->execute([$id]);
$en_compras = $stmt->fetchColumn();

if ($en_compras > 0) {
    echo "No se puede eliminar el proveedor porque está relacionado con compras.";
    exit;
}

// Si no está relacionado, eliminar
$stmt = $pdo->prepare("DELETE FROM proveedores WHERE id = ?");
try {
    $stmt->execute([$id]);
    echo "ok";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
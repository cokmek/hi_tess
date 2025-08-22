<?php
require_once '../../includes/conexion.php';

$id = $_POST['id'] ?? 0;
if (!$id) {
    echo "ID inválido";
    exit;
}

// Verifica si el producto está en compras_detalle o ventas_detalle
$stmt = $pdo->prepare("SELECT COUNT(*) FROM compras_detalle WHERE producto_id = ?");
$stmt->execute([$id]);
$en_compras = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM ventas_detalle WHERE producto_id = ?");
$stmt->execute([$id]);
$en_ventas = $stmt->fetchColumn();

if ($en_compras > 0 || $en_ventas > 0) {
    echo "No se puede eliminar el producto porque está relacionado con compras o ventas.";
    exit;
}

// Si no está relacionado, eliminar
$stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
try {
    $stmt->execute([$id]);
    echo "ok";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
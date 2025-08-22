<?php
require_once '../../includes/conexion.php';

$id = $_POST['id'] ?? 0;
if (!$id) {
    echo "ID inválido";
    exit;
}

// Verifica si el cliente está en ventas
$stmt = $pdo->prepare("SELECT COUNT(*) FROM ventas WHERE cliente_id = ?");
$stmt->execute([$id]);
$en_ventas = $stmt->fetchColumn();

if ($en_ventas > 0) {
    echo "No se puede eliminar el cliente porque está relacionado con ventas.";
    exit;
}

// Si no está relacionado, eliminar
$stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
try {
    $stmt->execute([$id]);
    echo "ok";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
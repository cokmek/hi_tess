<?php
require_once '../../includes/conexion.php';

$nombre = $_POST['nombre'] ?? '';
$marca = $_POST['marca'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio_compra = $_POST['precio_compra'] ?? 0;
$precio_venta = $_POST['precio_venta'] ?? 0;
$stock = $_POST['stock'] ?? 0;

if (!$nombre) {
    echo "Falta nombre";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO productos (nombre, marca, descripcion, precio_compra, precio_venta, stock) VALUES (?, ?, ?, ?, ?, ?)");
try {
    $stmt->execute([$nombre, $marca, $descripcion, $precio_compra, $precio_venta, $stock]);
    echo "ok";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

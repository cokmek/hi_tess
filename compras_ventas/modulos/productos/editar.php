<?php
require_once '../../includes/conexion.php';

$id = $_POST['id'] ?? 0;
$nombre = $_POST['nombre'] ?? '';
$marca = $_POST['marca'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio_compra = $_POST['precio_compra'] ?? 0;
$precio_venta = $_POST['precio_venta'] ?? 0;
$stock = $_POST['stock'] ?? 0;

if (!$id || !$nombre) {
    echo "Datos inválidos";
    exit;
}

$stmt = $pdo->prepare("UPDATE productos SET nombre=?, marca=?, descripcion=?, precio_compra=?, precio_venta=?, stock=? WHERE id=?");
try {
    $stmt->execute([$nombre, $marca, $descripcion, $precio_compra, $precio_venta, $stock, $id]);
    echo "ok";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

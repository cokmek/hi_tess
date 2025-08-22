<?php
require_once '../../includes/conexion.php';

$id = $_POST['id'] ?? 0;
$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';
$direccion = $_POST['direccion'] ?? '';

if (!$id || !$nombre || !$telefono || !$email || !$direccion) {
    http_response_code(400);
    echo "Faltan datos obligatorios";
    exit;
}

$stmt = $pdo->prepare("UPDATE proveedores SET nombre = ?, telefono = ?, email = ?, direccion = ? WHERE id = ?");
$result = $stmt->execute([$nombre, $telefono, $email, $direccion, $id]);

if ($result) {
    echo "OK";
} else {
    http_response_code(500);
    echo "Error al actualizar proveedor";
}

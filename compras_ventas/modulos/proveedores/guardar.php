<?php
require_once '../../includes/conexion.php';

// Recibir datos POST
$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';
$direccion = $_POST['direccion'] ?? '';

if (!$nombre || !$telefono || !$email || !$direccion) {
    http_response_code(400);
    echo "Faltan datos obligatorios";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO proveedores (nombre, telefono, email, direccion) VALUES (?, ?, ?, ?)");
$result = $stmt->execute([$nombre, $telefono, $email, $direccion]);

if ($result) {
    echo "OK";
} else {
    http_response_code(500);
    echo "Error al guardar proveedor";
}

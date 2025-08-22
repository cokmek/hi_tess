<?php
require_once '../../includes/conexion.php';

$nombre = $_POST['nombre'] ?? '';
$cedula = $_POST['cedula'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo = $_POST['correo'] ?? '';
$direccion = $_POST['direccion'] ?? '';

if (!$nombre) {
    echo "Falta nombre";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO clientes (nombre, cedula, telefono, correo, direccion) VALUES (?, ?, ?, ?, ?)");
try {
    $stmt->execute([$nombre, $cedula, $telefono, $correo, $direccion]);
    echo "ok";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


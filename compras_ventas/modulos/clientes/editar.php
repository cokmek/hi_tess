<?php
require_once '../../includes/conexion.php';

$id = $_POST['id'] ?? 0;
$nombre = $_POST['nombre'] ?? '';
$cedula = $_POST['cedula'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo = $_POST['correo'] ?? '';
$direccion = $_POST['direccion'] ?? '';

if (!$id || !$nombre) {
    echo "Datos inválidos";
    exit;
}

$stmt = $pdo->prepare("UPDATE clientes SET nombre=?, cedula=?, telefono=?, correo=?, direccion=? WHERE id=?");
try {
    $stmt->execute([$nombre, $cedula, $telefono, $correo, $direccion, $id]);
    echo "ok";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

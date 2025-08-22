<?php
require_once '../../includes/conexion.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta el id']);
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM proveedores WHERE id = ?");
$stmt->execute([$id]);
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$proveedor) {
    http_response_code(404);
    echo json_encode(['error' => 'Proveedor no encontrado']);
    exit;
}

header('Content-Type: application/json');
echo json_encode($proveedor);

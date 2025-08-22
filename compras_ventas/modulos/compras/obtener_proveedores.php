<?php
require_once '../../includes/conexion.php';

$stmt = $pdo->query("SELECT id, nombre FROM proveedores ORDER BY nombre ASC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);

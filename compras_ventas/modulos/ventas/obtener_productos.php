<?php
require_once '../../includes/conexion.php';

$stmt = $pdo->query("SELECT id, nombre, precio FROM productos ORDER BY nombre ASC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);

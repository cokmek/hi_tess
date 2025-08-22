<?php
require_once "../../includes/conexion.php";

$stmt = $pdo->query("SELECT id, nombre, stock, precio_compra FROM productos ORDER BY nombre");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($productos);

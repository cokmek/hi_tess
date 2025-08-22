<?php
require_once "../../includes/conexion.php";

$stmt = $pdo->prepare("SELECT id, nombre, stock, precio_compra FROM productos ORDER BY nombre");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($productos);

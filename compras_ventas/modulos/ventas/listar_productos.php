
<?php
require_once "../../includes/conexion.php";
$stmt = $pdo->query("SELECT id, nombre, precio_venta, stock FROM productos WHERE stock > 0 ORDER BY nombre");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($productos);
?>
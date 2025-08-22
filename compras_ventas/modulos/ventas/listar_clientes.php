
<?php
require_once "../../includes/conexion.php";
$stmt = $pdo->query("SELECT id, nombre FROM clientes ORDER BY nombre");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($clientes);
?>
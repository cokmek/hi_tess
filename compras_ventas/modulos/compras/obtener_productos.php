<?php
require_once "../../includes/conexion.php";

try {
    $stmt = $pdo->prepare("SELECT id, nombre, precio_compra FROM productos ORDER BY nombre");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($productos);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

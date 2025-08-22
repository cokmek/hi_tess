<?php
require_once '../../includes/conexion.php';
header('Content-Type: application/json');

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "ID inválido"
    ]);
    exit;
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("DELETE FROM ventas_detalle WHERE venta_id = ?");
    $stmt->execute([$id]);
    $stmt = $pdo->prepare("DELETE FROM ventas WHERE id = ?");
    $stmt->execute([$id]);
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Venta eliminada correctamente"
    ]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode([
        "success" => false,
        "message" => "Error al eliminar la venta: " . $e->getMessage()
    ]);
}
?>
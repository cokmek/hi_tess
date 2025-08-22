
<?php
require_once "../../includes/conexion.php";
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
    // Iniciar transacción
    $pdo->beginTransaction();

    // Eliminar detalles de la compra
    $stmt = $pdo->prepare("DELETE FROM compras_detalle WHERE compra_id = ?");
    $stmt->execute([$id]);

    // Eliminar la compra
    $stmt = $pdo->prepare("DELETE FROM compras WHERE id = ?");
    $stmt->execute([$id]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Compra eliminada correctamente"
    ]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode([
        "success" => false,
        "message" => "Error al eliminar la compra: " . $e->getMessage()
    ]);
}
?>
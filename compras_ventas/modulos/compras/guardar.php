
<?php



require_once "../../includes/conexion.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Leer datos JSON del cuerpo de la petición
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Validar datos principales
        if (
            empty($data['proveedor_id']) ||
            !isset($data['total']) ||
            !is_numeric($data['total']) ||
            empty($data['productos']) ||
            !is_array($data['productos'])
        ) {
            throw new Exception("Datos incompletos o inválidos para guardar la compra");
        }

        $proveedor_id = intval($data['proveedor_id']);
        $total = floatval($data['total']);
        $productos = $data['productos'];

        if ($proveedor_id <= 0 || $total < 0) {
            throw new Exception("Proveedor o total inválido");
        }

        // Validar productos
        foreach ($productos as $prod) {
            if (
                !isset($prod['id'], $prod['cantidad'], $prod['precio']) ||
                !is_numeric($prod['id']) ||
                !is_numeric($prod['cantidad']) ||
                !is_numeric($prod['precio']) ||
                intval($prod['id']) <= 0 ||
                intval($prod['cantidad']) <= 0 ||
                floatval($prod['precio']) < 0
            ) {
                throw new Exception("Producto con datos incompletos o inválidos");
            }
        }

        // Iniciar transacción
        $pdo->beginTransaction();

        // Insertar compra
        $stmt = $pdo->prepare("INSERT INTO compras (proveedor_id, fecha, total) VALUES (?, NOW(), ?)");
        $stmt->execute([$proveedor_id, $total]);
        $compra_id = $pdo->lastInsertId();

        // Insertar detalle y actualizar stock
        $stmt_detalle = $pdo->prepare("INSERT INTO compras_detalle (compra_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt_stock = $pdo->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");

        foreach ($productos as $prod) {
            $producto_id = intval($prod['id']);
            $cantidad = intval($prod['cantidad']);
            $precio = floatval($prod['precio']);

            // Guardar detalle
            $stmt_detalle->execute([$compra_id, $producto_id, $cantidad, $precio]);
            // Actualizar stock
            $stmt_stock->execute([$cantidad, $producto_id]);
        }

        $pdo->commit();
        echo json_encode([
            "success" => true,
            "message" => "Compra registrada correctamente",
            "compra_id" => $compra_id
        ]);
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo json_encode([
            "success" => false,
            "message" => "Error al guardar la compra: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
}
?>
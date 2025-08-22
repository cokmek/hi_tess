<?php
require_once "../../includes/conexion.php";

try {
    $stmt = $pdo->prepare("
        SELECT c.id, c.fecha, p.nombre AS proveedor, c.total
        FROM compras c
        INNER JOIN proveedores p ON c.proveedor_id = p.id
        ORDER BY c.fecha DESC
    ");
    $stmt->execute();
    $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error al obtener compras: " . $e->getMessage());
}
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($compras)): ?>
            <?php foreach ($compras as $compra): ?>
                <tr>
                    <td><?= htmlspecialchars($compra['id']) ?></td>
                    <td><?= htmlspecialchars($compra['fecha']) ?></td>
                    <td><?= htmlspecialchars($compra['proveedor']) ?></td>
                    <td>$<?= number_format($compra['total'], 2) ?></td>
                    <td>
                        <button class="btn btn-info btn-ver-compra" data-id="<?= $compra['id'] ?>">Ver</button>
                        <button class="btn btn-danger btn-eliminar-compra" data-id="<?= $compra['id'] ?>">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No hay compras registradas</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

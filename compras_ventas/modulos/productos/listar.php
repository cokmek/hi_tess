<?php
require_once '../../includes/conexion.php'; // debe definir $pdo (PDO)

$stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
    echo "<tr><td colspan='7' class='text-center'>Sin productos</td></tr>";
    exit;
}

foreach ($rows as $r) {
    $id = htmlspecialchars($r['id']);
    $nombre = htmlspecialchars($r['nombre']);
    $marca = htmlspecialchars($r['marca']);
    $precio_compra = number_format($r['precio_compra'],2);
    $precio_venta = number_format($r['precio_venta'],2);
    $stock = htmlspecialchars($r['stock']);

    echo "<tr>
            <td>{$id}</td>
            <td>{$nombre}</td>
            <td>{$marca}</td>
            <td>\${$precio_compra}</td>
            <td>\${$precio_venta}</td>
            <td>{$stock}</td>
            <td>
              <button class='btn btn-sm btn-warning btnEditarProducto' data-id='{$id}'>Editar</button>
              <button class='btn btn-sm btn-danger btnEliminarProducto' data-id='{$id}'>Eliminar</button>
            </td>
          </tr>";
}


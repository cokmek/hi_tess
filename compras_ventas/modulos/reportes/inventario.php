<?php
require_once '../../includes/conexion.php';

$sql = "SELECT nombre, stock, precio_venta FROM productos ORDER BY nombre ASC";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>{$row['nombre']}</td>
            <td>{$row['stock']}</td>
            <td>{$row['precio_venta']}</td>
          </tr>";
}
?>

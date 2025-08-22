<?php
require_once '../../includes/conexion.php';

$stmt = $pdo->query("SELECT v.id, c.nombre AS cliente, v.fecha, v.total
                     FROM ventas v
                     JOIN clientes c ON v.cliente_id = c.id
                     ORDER BY v.id DESC");

echo "<table class='table table-bordered'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>";
while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['cliente']}</td>
            <td>{$fila['fecha']}</td>
            <td>{$fila['total']}</td>
            <td>
                <button class='btn btn-info btn-ver-venta' data-id='{$fila['id']}'>Ver</button>
                <button class='btn btn-danger btn-eliminar-venta' data-id='{$fila['id']}'>Eliminar</button>
            </td>
          </tr>";
}
echo "</tbody></table>";
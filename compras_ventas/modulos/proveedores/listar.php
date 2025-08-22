<?php
require_once '../../includes/conexion.php';

$stmt = $pdo->query("SELECT * FROM proveedores ORDER BY id DESC");
while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>{$fila['id']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['telefono']}</td>
            <td>{$fila['email']}</td>
            <td>{$fila['direccion']}</td>
            <td>
                <button class='btn btn-sm btn-warning btnEditarProv' data-id='{$fila['id']}'>Editar</button>
                <button class='btn btn-sm btn-danger btnEliminarProv' data-id='{$fila['id']}'>Eliminar</button>
            </td>
          </tr>";
}

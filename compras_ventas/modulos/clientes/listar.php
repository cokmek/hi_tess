<?php
require_once '../../includes/conexion.php'; // usa $pdo

$stmt = $pdo->query("SELECT * FROM clientes ORDER BY id DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
    echo "<tr><td colspan='7' class='text-center'>Sin clientes</td></tr>";
    exit;
}

foreach ($rows as $r) {
    $id = htmlspecialchars($r['id']);
    $nombre = htmlspecialchars($r['nombre']);
    $cedula = htmlspecialchars($r['cedula']);
    $telefono = htmlspecialchars($r['telefono']);
    $correo = htmlspecialchars($r['correo']);
    $direccion = htmlspecialchars($r['direccion']);

    echo "<tr>
            <td>{$id}</td>
            <td>{$nombre}</td>
            <td>{$cedula}</td>
            <td>{$telefono}</td>
            <td>{$correo}</td>
            <td>{$direccion}</td>
            <td>
              <button class='btn btn-sm btn-warning btnEditarCliente' data-id='{$id}'>Editar</button>
              <button class='btn btn-sm btn-danger btnEliminarCliente' data-id='{$id}'>Eliminar</button>
            </td>
          </tr>";
}

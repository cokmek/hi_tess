<!-- modulos/clientes/index.php -->
<div class="container mt-3">
  <h4>Gestión de Clientes</h4>
  <button id="btnNuevoCliente" class="btn btn-primary mb-3">Nuevo Cliente</button>

  <table id="tabla-clientes" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Cédula</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Dirección</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- filas cargadas por JS -->
    </tbody>
  </table>
</div>

<!-- Modal para crear/editar cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCliente">
        <div class="modal-header">
          <h5 class="modal-title" id="modalClienteLabel">Nuevo Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="clienteId" name="id" value="">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="cedula" class="form-label">Cédula</label>
            <input type="text" id="cedula" name="cedula" class="form-control">
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" id="telefono" name="telefono" class="form-control">
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" id="correo" name="correo" class="form-control">
          </div>
          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <textarea id="direccion" name="direccion" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" id="btnGuardarCliente" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Carga el JS del módulo -->
<script src="modulos/clientes/clientes.js"></script>

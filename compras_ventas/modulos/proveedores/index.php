<div class="container">
  <h4>Gestión de Proveedores</h4>
  <button id="btnNuevoProveedor" class="btn btn-primary mb-3">Nuevo Proveedor</button>

  <table id="tablaProveedores" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Dirección</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- Aquí se llenarán los proveedores desde JS -->
    </tbody>
  </table>
</div>

<!-- Modal para nuevo/editar proveedor -->
<div class="modal fade" id="modalProveedor" tabindex="-1" aria-labelledby="modalProveedorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProveedorLabel">Nuevo Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formProveedor">
          <input type="hidden" id="proveedorId" />
          <div class="mb-3">
            <label for="nombreProveedor" class="form-label">Nombre</label>
            <input type="text" id="nombreProveedor" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="telefonoProveedor" class="form-label">Teléfono</label>
            <input type="text" id="telefonoProveedor" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="emailProveedor" class="form-label">Email</label>
            
            <input type="email" id="emailProveedor" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="direccionProveedor" class="form-label">Dirección</label>
            <input type="text" id="direccionProveedor" class="form-control" required />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btnGuardarProveedor" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

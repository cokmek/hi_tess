<!-- modulos/productos/index.php -->
<div class="container mt-3">
  <h4>Gestión de Productos</h4>
  <button id="btnNuevoProducto" class="btn btn-primary mb-3">Nuevo Producto</button>

  <table id="tabla-productos" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Precio Compra</th>
        <th>Precio Venta</th>
        <th>Stock</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- filas cargadas por JS -->
    </tbody>
  </table>
</div>

<!-- Modal crear/editar producto -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProducto">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProductoLabel">Nuevo Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="productoId" name="id" value="">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" id="marca" name="marca" class="form-control">
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label for="precio_compra" class="form-label">Precio Compra</label>
            <input type="number" id="precio_compra" name="precio_compra" step="0.01" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio Venta</label>
            <input type="number" id="precio_venta" name="precio_venta" step="0.01" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" id="btnGuardarProducto" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- cargar JS del módulo -->
<script src="modulos/productos/productos.js"></script>

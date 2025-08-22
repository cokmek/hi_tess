<div class="container">
  <h4>Ventas</h4>

  <button id="btnNuevo" class="btn btn-primary mb-3">Nueva Venta</button>

  <div id="lista-ventas">
    <!-- Aquí se cargan las ventas -->
  </div>

  <!-- Modal para Nueva / Editar Venta -->
  <div class="modal fade" id="modalVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="formVenta" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nueva Venta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id" name="id" />

          <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select id="cliente_id" name="cliente_id" class="form-select" required>
              <option value="">Seleccione un cliente</option>
              <!-- Opciones cargadas dinámicamente -->
            </select>
          </div>

          <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required />
          </div>

          <h6>Detalle de venta</h6>
          <table class="table table-bordered" id="detalleVentaTable">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <!-- Filas dinámicas -->
            </tbody>
          </table>
          <button type="button" id="btnAgregarProducto" class="btn btn-secondary mb-3">Agregar Producto</button>

          <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="text" id="total" name="total" class="form-control" readonly value="0" />
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar Venta</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Seleccionar Producto -->
<div class="modal fade" id="modalSeleccionarProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select id="selectProducto" class="form-select mb-2"></select>
        <input type="number" id="cantidadProducto" class="form-control mb-2" placeholder="Cantidad" min="1" value="1">
        <input type="number" id="precioProducto" class="form-control mb-2" placeholder="Precio" min="0" step="0.01">
      </div>
      <div class="modal-footer">
        <button type="button" id="btnAgregarProductoModal" class="btn btn-primary">Agregar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Ver Detalles de Venta -->
<div class="modal fade" id="modalVerVenta" tabindex="-1" aria-labelledby="modalVerVentaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerVentaLabel">Detalle de Venta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detalle-venta-body">
        <!-- Aquí se cargan los detalles -->
      </div>
    </div>
  </div>
</div>

<script src="modulos/ventas/ventas.js"></script>

<?php
// Aquí puedes agregar lógica PHP si es necesario
?>
<div class="container">
  <h2>Gestión de Compras</h2>
  <button id="btnNuevaCompra" class="btn btn-primary mb-3">Nueva Compra</button>

  <div id="lista-compras"></div>

  <!-- Modal Nueva Compra -->
  <div class="modal fade" id="modalCompra" tabindex="-1" aria-labelledby="modalCompraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="formCompra">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCompraLabel">Nueva Compra</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="compraId" name="id" value="">

            <div class="mb-3">
              <label for="proveedor_id" class="form-label">Proveedor</label>
              <select id="proveedor_id" name="proveedor_id" class="form-select" required>
                <option value="">Seleccione un proveedor</option>
                <?php
                  require_once "../../includes/conexion.php";
                  $stmt = $pdo->prepare("SELECT id, nombre FROM proveedores ORDER BY nombre");
                  $stmt->execute();
                  $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($proveedores as $row) {
                    echo "<option value='{$row['id']}'>" . htmlspecialchars($row['nombre']) . "</option>";
                  }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Productos</label>
              <div id="productos-lista"></div>
              <button type="button" id="btnAgregarProducto" class="btn btn-secondary mb-2">Agregar Producto</button>
            </div>

            <div>
              <h5>Total: $<span id="totalCompra">0.00</span></h5>
              <input type="hidden" id="total" name="total" value="0">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success">Guardar Compra</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Ver Detalles (fuera de cualquier otro modal) -->
  <div class="modal fade" id="modalVerCompra" tabindex="-1" aria-labelledby="modalVerCompraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalVerCompraLabel">Detalle de Compra</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="detalle-compra-body">
          <!-- Aquí se cargan los detalles -->
        </div>
      </div>
    </div>
  </div>
</div>

<script src="modulos/compras/compras.js"></script>
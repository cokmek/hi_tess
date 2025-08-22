  <div class="container mt-3">
    <h4>Reportes</h4>

    <ul class="nav nav-tabs mb-3" id="tabReportes" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ventas-tab" data-bs-toggle="tab" data-bs-target="#ventas" type="button" role="tab" aria-controls="ventas" aria-selected="true">Ventas</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="compras-tab" data-bs-toggle="tab" data-bs-target="#compras" type="button" role="tab" aria-controls="compras" aria-selected="false">Compras</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="inventario-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button" role="tab" aria-controls="inventario" aria-selected="false">Inventario</button>
        </li>
    </ul>

    <div class="tab-content" id="tabReportesContent">
        <!-- Ventas -->
        <div class="tab-pane fade show active" id="ventas" role="tabpanel" aria-labelledby="ventas-tab">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="date" id="ventaDesde" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="date" id="ventaHasta" class="form-control" required>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button id="btnBuscarVentas" class="btn btn-primary">Buscar</button>
                    <button id="btnImprimirVentas" class="btn btn-success">Imprimir</button>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody id="tablaVentas"></tbody>
            </table>
        </div>

        <!-- Compras -->
        <div class="tab-pane fade" id="compras" role="tabpanel" aria-labelledby="compras-tab">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="date" id="compraDesde" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="date" id="compraHasta" class="form-control" required>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button id="btnBuscarCompras" class="btn btn-primary">Buscar</button>
                    <button id="btnImprimirCompras" class="btn btn-success">Imprimir</button>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Total</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody id="tablaCompras"></tbody>
            </table>
        </div>

        <!-- Inventario -->
        <div class="tab-pane fade" id="inventario" role="tabpanel" aria-labelledby="inventario-tab">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody id="tablaInventario"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modales -->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-receipt"></i> Detalle de Venta</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detalleVentaContent">
        <div class="text-center text-muted">
          <i class="bi bi-hourglass-split"></i> Cargando detalles...
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDetalleCompra" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="bi bi-box-seam"></i> Detalle de Compra</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detalleCompraContent">
        <div class="text-center text-muted">
          <i class="bi bi-hourglass-split"></i> Cargando detalles...
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="modulos/reportes/reportes.js"></script>

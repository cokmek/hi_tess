$(document).ready(function () {
  let detalle = [];
  let productosDisponibles = [];

  cargarVentas();
  cargarClientes();

  function cargarVentas() {
    $.get("modulos/ventas/listar.php", function (data) {
      $("#lista-ventas").html(data);
    });
  }

  function cargarClientes() {
    $.getJSON("modulos/ventas/listar_clientes.php", function (clientes) {
      let $select = $("#cliente_id");
      $select.empty().append('<option value="">Seleccione un cliente</option>');
      clientes.forEach(cliente => {
        $select.append(`<option value="${cliente.id}">${cliente.nombre}</option>`);
      });
    });
  }

  function cargarProductos() {
    $.getJSON("modulos/ventas/listar_productos.php", function (productos) {
      productosDisponibles = productos;
      let $select = $("#selectProducto");
      $select.empty().append('<option value="">Seleccione un producto</option>');
      productos.forEach(prod => {
        $select.append(`<option value="${prod.id}" data-precio="${prod.precio_venta}" data-stock="${prod.stock}">${prod.nombre} (Stock: ${prod.stock})</option>`);
      });
    });
  }

  $(document).off("click", "#btnNuevo").on("click", "#btnNuevo", function () {
    $("#formVenta")[0].reset();
    detalle = [];
    actualizarTablaDetalle();
    cargarClientes();
    $("#modalVenta .modal-title").text("Nueva Venta");
    new bootstrap.Modal(document.getElementById('modalVenta')).show();
  });

  $(document).off("click", "#btnAgregarProducto").on("click", "#btnAgregarProducto", function () {
    cargarProductos();
    $("#cantidadProducto").val(1);
    $("#precioProducto").val('');
    $("#modalSeleccionarProducto").modal("show");
  });

  $(document).off("change", "#selectProducto").on("change", "#selectProducto", function () {
    let precio = $("#selectProducto option:selected").data("precio");
    if (precio !== undefined) {
      $("#precioProducto").val(precio);
    }
  });

  $(document).off("click", "#btnAgregarProductoModal").on("click", "#btnAgregarProductoModal", function () {
    let productoId = $("#selectProducto").val();
    let producto = productosDisponibles.find(p => p.id == productoId);
    let cantidad = parseInt($("#cantidadProducto").val(), 10);
    let precio_venta = parseFloat($("#precioProducto").val());

    if (producto && cantidad > 0 && precio_venta > 0 && cantidad <= producto.stock) {
      detalle.push({
        producto_id: producto.id,
        producto_nombre: producto.nombre,
        cantidad: cantidad,
        precio_venta: precio_venta
      });
      actualizarTablaDetalle();
      $("#modalSeleccionarProducto").modal("hide");
    } else {
      alert("Datos inválidos o cantidad mayor al stock.");
    }
  });

  function actualizarTablaDetalle() {
    let tbody = $("#detalleVentaTable tbody");
    tbody.empty();
    let total = 0;

    detalle.forEach((item, index) => {
      let subtotal = item.cantidad * item.precio_venta;
      total += subtotal;
      tbody.append(`
        <tr>
          <td>${item.producto_nombre}</td>
          <td><input type="number" min="1" value="${item.cantidad}" class="form-control cantidad" data-index="${index}"></td>
          <td><input type="number" step="0.01" value="${item.precio_venta}" class="form-control precio" data-index="${index}"></td>
          <td>${subtotal.toFixed(2)}</td>
          <td><button type="button" class="btn btn-danger btn-sm btnEliminarDetalle" data-index="${index}">Eliminar</button></td>
        </tr>
      `);
    });

    $("#total").val(total.toFixed(2));
  }

  $(document).off("input", ".cantidad, .precio").on("input", ".cantidad, .precio", function () {
    let index = $(this).data("index");
    let valor = $(this).val();
    if ($(this).hasClass("cantidad")) {
      detalle[index].cantidad = parseInt(valor) || 1;
    } else {
      detalle[index].precio_venta = parseFloat(valor) || 0;
    }
    actualizarTablaDetalle();
  });

  $(document).off("click", ".btnEliminarDetalle").on("click", ".btnEliminarDetalle", function () {
    let index = $(this).data("index");
    detalle.splice(index, 1);
    actualizarTablaDetalle();
  });

  $(document).off("submit", "#formVenta").on("submit", "#formVenta", function (e) {
    e.preventDefault();
    if (detalle.length === 0) {
      alert("Debe agregar al menos un producto al detalle.");
      return;
    }

    let data = {
      cliente_id: $("#cliente_id").val(),
      fecha: $("#fecha").val(),
      total: $("#total").val(),
      productos: detalle
    };

    $.ajax({
      url: "modulos/ventas/guardar.php",
      type: "POST",
      data: JSON.stringify(data),
      contentType: "application/json",
      dataType: "json",
      success: function (resp) {
        if (resp.success) {
          bootstrap.Modal.getInstance(document.getElementById('modalVenta')).hide();
          detalle = [];
          actualizarTablaDetalle();
          cargarVentas();

          let ventana = window.open(`modulos/ventas/ticket.php?id=${resp.venta_id}`, '', 'width=300,height=500');

          let checkTicket = setInterval(() => {
            if (ventana.closed) {
              clearInterval(checkTicket);
              $('.modal-backdrop').remove();
              $('body').removeClass('modal-open');
              $('body').css('padding-right', '');
            }
          }, 500);

        } else {
          alert("Error: " + resp.message);
        }
      },
      error: function () {
        alert("Error al guardar la venta.");
      }
    });
  });

  $(document).off("submit", "#formFiltroVentas").on("submit", "#formFiltroVentas", function (e) {
    e.preventDefault();
    let datos = $(this).serialize();
    $.get("modulos/reportes/listar_ventas.php", datos, function (html) {
      $("#resultadosVentas").html(html);
    });
  });

  $(document).off("click", ".btn-ver-venta").on("click", ".btn-ver-venta", function () {
    let ventaId = $(this).data("id");
    $.get("modulos/ventas/detalle.php", { id: ventaId }, function (html) {
      $("#detalle-venta-body").html(html);
      $("#modalVerVenta").modal("show");
    });
  });

  $(document).off("click", ".btn-eliminar-venta").on("click", ".btn-eliminar-venta", function () {
    let ventaId = $(this).data("id");
    if (confirm("¿Seguro que desea eliminar esta venta?")) {
      $.post("modulos/ventas/eliminar.php", { id: ventaId }, function (response) {
        if (response.success) {
          $("#lista-ventas").empty();
          cargarVentas();
        } else {
          alert("Error: " + response.message);
        }
      }, "json");
    }
  });
});

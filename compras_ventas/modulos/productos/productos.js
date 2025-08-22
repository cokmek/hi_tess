// modulos/productos/productos.js
function inicializarModuloProductos() {
  const $tbody = $("#tabla-productos tbody");

  function cargarProductos() {
    $.get("modulos/productos/listar.php", function (html) {
      $tbody.html(html);
    }).fail(function() {
      $tbody.html("<tr><td colspan='7'>Error cargando productos</td></tr>");
    });
  }

  // carga inicial
  cargarProductos();

  // Abrir modal nuevo
  $(document).off("click", "#btnNuevoProducto").on("click", "#btnNuevoProducto", function () {
    $("#formProducto")[0].reset();
    $("#productoId").val("");
    $("#modalProductoLabel").text("Nuevo Producto");
    const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
    modal.show();
  });

  // Guardar / editar
  $(document).off("submit", "#formProducto").on("submit", "#formProducto", function (e) {
    e.preventDefault();
    const id = $("#productoId").val();
    const url = id ? "modulos/productos/editar.php" : "modulos/productos/guardar.php";

    $.post(url, $(this).serialize(), function (resp) {
      if (resp.trim() === "ok") {
        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalProducto'));
        if (modalInstance) modalInstance.hide();
        cargarProductos();
      } else {
        alert("Error: " + resp);
      }
    }).fail(function() {
      alert("Error en la petición al servidor.");
    });
  });

  // Editar -> obtener datos y abrir modal
  $(document).off("click", ".btnEditarProducto").on("click", ".btnEditarProducto", function () {
    const id = $(this).data("id");
    $.getJSON("modulos/productos/obtener.php", { id: id }, function (data) {
      if (!data || !data.id) {
        alert("Producto no encontrado.");
        return;
      }
      $("#productoId").val(data.id);
      $("#nombre").val(data.nombre);
      $("#marca").val(data.marca);
      $("#descripcion").val(data.descripcion);
      $("#precio_compra").val(data.precio_compra);
      $("#precio_venta").val(data.precio_venta);
      $("#stock").val(data.stock);
      $("#modalProductoLabel").text("Editar Producto");
      const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
      modal.show();
    }).fail(function() {
      alert("Error obteniendo producto.");
    });
  });

  // Eliminar
  $(document).off("click", ".btnEliminarProducto").on("click", ".btnEliminarProducto", function () {
    const id = $(this).data("id");
    if (!confirm("¿Seguro que desea eliminar el producto?")) return;

    $.post("modulos/productos/eliminar.php", { id: id }, function (resp) {
      if (resp.trim() === "ok") {
        cargarProductos();
      } else {
        alert("Error al eliminar: " + resp);
      }
    }).fail(function() {
      alert("Error en la petición de eliminación.");
    });
  });

  // fin inicializador
}

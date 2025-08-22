function inicializarModuloProveedores() {
  console.log("Módulo Proveedores inicializado");

  const $tbody = $("#tablaProveedores tbody");

  function cargarProveedores() {
    $.ajax({
      url: "modulos/proveedores/listar.php",
      method: "GET",
      success: function (data) {
        $tbody.html(data);
      },
      error: function () {
        alert("Error al cargar la lista de proveedores");
      },
    });
  }

  cargarProveedores();

  $("#btnNuevoProveedor").off("click").on("click", function () {
    $("#proveedorId").val("");
    $("#nombreProveedor").val("");
    $("#telefonoProveedor").val("");
    $("#emailProveedor").val("");
    $("#direccionProveedor").val("");
    $("#modalProveedorLabel").text("Nuevo Proveedor");
    $("#modalProveedor").modal("show");
  });

  $("#btnGuardarProveedor").off("click").on("click", function () {
    const id = $("#proveedorId").val();
    const nombre = $("#nombreProveedor").val();
    const telefono = $("#telefonoProveedor").val();
    const email = $("#emailProveedor").val();
    const direccion = $("#direccionProveedor").val();

    if (!nombre || !telefono || !email || !direccion) {
      alert("Todos los campos son obligatorios");
      return;
    }

    $.ajax({
      url: id ? "modulos/proveedores/editar.php" : "modulos/proveedores/guardar.php",
      method: "POST",
      data: { id, nombre, telefono, email, direccion },
      success: function (respuesta) {
        if (respuesta.trim() === "OK") {
          $("#modalProveedor").modal("hide");
          cargarProveedores();
        } else {
          alert("Error: " + respuesta);
        }
      },
      error: function () {
        alert("Error al guardar proveedor");
      },
    });
  });

  $tbody.off("click", ".btnEditarProv").on("click", ".btnEditarProv", function () {
    const id = $(this).data("id");
    $.ajax({
      url: "modulos/proveedores/obtener.php",
      method: "GET",
      data: { id },
      dataType: "json",
      success: function (proveedor) {
        $("#proveedorId").val(proveedor.id);
        $("#nombreProveedor").val(proveedor.nombre);
        $("#telefonoProveedor").val(proveedor.telefono);
        $("#emailProveedor").val(proveedor.email);
        $("#direccionProveedor").val(proveedor.direccion);
        $("#modalProveedorLabel").text("Editar Proveedor");
        $("#modalProveedor").modal("show");
      },
      error: function () {
        alert("Error al obtener datos del proveedor");
      },
    });
  });

  $tbody.off("click", ".btnEliminarProv").on("click", ".btnEliminarProv", function () {
    const id = $(this).data("id");
    if (confirm("¿Seguro que deseas eliminar este proveedor?")) {
      $.ajax({
        url: "modulos/proveedores/eliminar.php",
        method: "POST",
        data: { id },
        success: function (respuesta) {
          if (respuesta.trim() === "OK") {
            cargarProveedores();
          } else {
            alert("Error al eliminar proveedor");
          }
        },
        error: function () {
          alert("Error al eliminar proveedor");
        },
      });
    }
  });
}

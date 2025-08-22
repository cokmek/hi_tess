// modulos/clientes/clientes.js
function inicializarModuloClientes() {
  // todo el estado queda dentro de la función (no globals)
  const $tbody = $("#tabla-clientes tbody");

  // Cargar lista
  function cargarClientes() {
    $.get("modulos/clientes/listar.php", function (html) {
      $tbody.html(html);
    }).fail(function() {
      $tbody.html("<tr><td colspan='7'>Error cargando clientes</td></tr>");
    });
  }

  // Inicial carga
  cargarClientes();

  // Abrir modal nuevo
  $(document).off("click", "#btnNuevoCliente").on("click", "#btnNuevoCliente", function () {
    $("#formCliente")[0].reset();
    $("#clienteId").val("");
    $("#modalClienteLabel").text("Nuevo Cliente");
    const modal = new bootstrap.Modal(document.getElementById('modalCliente'));
    modal.show();
  });

  // Guardar / editar (submit del form)
  $(document).off("submit", "#formCliente").on("submit", "#formCliente", function (e) {
    e.preventDefault();
    const id = $("#clienteId").val();
    const url = id ? "modulos/clientes/editar.php" : "modulos/clientes/guardar.php";

    $.post(url, $(this).serialize(), function (resp) {
      if (resp.trim() === "ok") {
        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalCliente'));
        if (modalInstance) modalInstance.hide();
        cargarClientes();
      } else {
        alert("Error: " + resp);
      }
    }).fail(function() {
      alert("Error en la petición al servidor.");
    });
  });

  // Editar: cargar datos en modal -> usamos delegación porque las filas se recargan
  $(document).off("click", ".btnEditarCliente").on("click", ".btnEditarCliente", function () {
    const id = $(this).data("id");
    $.getJSON("modulos/clientes/obtener.php", { id: id }, function (data) {
      if (!data || !data.id) {
        alert("No se encontró el cliente.");
        return;
      }
      $("#clienteId").val(data.id);
      $("#nombre").val(data.nombre);
      $("#cedula").val(data.cedula);
      $("#telefono").val(data.telefono);
      $("#correo").val(data.correo);
      $("#direccion").val(data.direccion);
      $("#modalClienteLabel").text("Editar Cliente");
      const modal = new bootstrap.Modal(document.getElementById('modalCliente'));
      modal.show();
    }).fail(function() {
      alert("Error obteniendo datos del cliente.");
    });
  });

  // Eliminar
  $(document).off("click", ".btnEliminarCliente").on("click", ".btnEliminarCliente", function () {
    const id = $(this).data("id");
    if (!confirm("¿Seguro que desea eliminar el cliente?")) return;

    $.post("modulos/clientes/eliminar.php", { id: id }, function (resp) {
      if (resp.trim() === "ok") {
        cargarClientes();
      } else {
        alert("Error al eliminar: " + resp);
      }
    }).fail(function() {
      alert("Error en la petición de eliminación.");
    });
  });

  // opcional: export/otros botones si quieres
}

$(document).ready(function () {

    // Cargar lista al entrar
    cargarCompras();

    // Abrir modal
    $("#btnNuevaCompra").off("click").on("click", function () {
        $("#formCompra")[0].reset();
        $("#productos-lista").empty();
        $("#totalCompra").text("0.00");
        $("#total").val(0);
        $("#modalCompra").modal("show");
    });

    // Botón agregar producto
    $("#btnAgregarProducto").off("click").on("click", function () {
        agregarProducto();
    });

    
    // ...existing code...
// Guardar compra
$("#formCompra").off("submit").on("submit", function (e) {
    e.preventDefault();

    // Construir array de productos
    let productos = [];
    $(".producto-item").each(function () {
        let producto_id = $(this).find(".producto-select").val();
        let cantidad = $(this).find(".cantidad-input").val();
        let precio = $(this).find(".producto-select option:selected").data("precio");

        if (producto_id && cantidad && precio !== undefined) {
            productos.push({
                id: producto_id,
                cantidad: cantidad,
                precio: precio
            });
        }
    });

    // Validar que haya productos
    if (productos.length === 0) {
        alert("Agregue al menos un producto.");
        return;
    }

    // Preparar datos
    let data = {
        proveedor_id: $("#proveedor_id").val(),
        total: $("#total").val(),
        productos: productos
    };

    $.ajax({
        url: "modulos/compras/guardar.php",
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#modalCompra").modal("hide");
                cargarCompras();
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function (xhr) {
            alert("Error al guardar la compra.");
        }
    });
});


// Cargar compras
function cargarCompras() {
    $.get("modulos/compras/listar.php", function (data) {
        $("#lista-compras").html(data);
    });
}


// Delegar evento para botón Ver
//$(document).on("click", ".btn-ver-compra", function () {
  //  let compraId = $(this).data("id");
    // Aquí puedes abrir un modal o hacer una petición AJAX para mostrar los detalles
 //   alert("Ver compra: " + compraId);
    // Ejemplo: mostrarDetallesCompra(compraId);
//});

// Delegar evento para botón Eliminar
$(document).on("click", ".btn-eliminar-compra", function () {
    let compraId = $(this).data("id");
    if (confirm("¿Seguro que desea eliminar esta compra?")) {
        $.post("modulos/compras/eliminar.php", { id: compraId }, function (response) {
            if (response.success) {
                cargarCompras();
            } else {
                alert("Error: " + response.message);
            }
        }, "json");
    }
});
// ...existing code...

// Delegar evento para botón Ver
$(document).on("click", ".btn-ver-compra", function () {
    let compraId = $(this).data("id");
     $.get("modulos/compras/detalle.php", { id: compraId }, function (html) {
         $("#detalle-compra-body").html(html);
         $("#modalVerCompra").modal("show");
    });
});

// ...existing code...



// Agregar producto
function agregarProducto() {
    $.getJSON("modulos/compras/obtener_productos.php", function (productos) {
        if (productos.error) {
            alert("Error: " + productos.error);
            return;
        }

        let opciones = '<option value="">Seleccione un producto</option>';
        productos.forEach(function (prod) {
            opciones += `<option value="${prod.id}" data-precio="${prod.precio_compra}">${prod.nombre}</option>`;
        });

        let fila = `
            <div class="row mb-2 producto-item">
                <div class="col-md-5">
                    <select name="producto_id[]" class="form-select producto-select" required>
                        ${opciones}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="cantidad[]" class="form-control cantidad-input" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="subtotal[]" class="form-control subtotal" readonly>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm eliminar-producto">&times;</button>
                </div>
            </div>
        `;

        $("#productos-lista").append(fila);
    });
}

// Eventos dinámicos
$(document).on("change", ".producto-select, .cantidad-input", function () {
    calcularTotales();
});

$(document).on("click", ".eliminar-producto", function () {
    $(this).closest(".producto-item").remove();
    calcularTotales();
});

// Calcular totales
function calcularTotales() {
    let total = 0;

    $(".producto-item").each(function () {
        let precio = parseFloat($(this).find(".producto-select option:selected").data("precio")) || 0;
        let cantidad = parseInt($(this).find(".cantidad-input").val()) || 0;
        let subtotal = precio * cantidad;

        $(this).find(".subtotal").val(subtotal.toFixed(2));
        total += subtotal;
    });

    $("#totalCompra").text(total.toFixed(2));
    $("#total").val(total.toFixed(2));
}
});

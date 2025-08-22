$(document).ready(function () {
    const hoy = new Date().toISOString().slice(0, 10);
    $("#ventaDesde, #ventaHasta, #compraDesde, #compraHasta").val(hoy);

    const modalVenta = new bootstrap.Modal(document.getElementById('modalDetalleVenta'));
    const modalCompra = new bootstrap.Modal(document.getElementById('modalDetalleCompra'));

    // Buscar ventas
    $("#btnBuscarVentas").off("click").on("click", function (e) {
        e.preventDefault();
        const desde = $("#ventaDesde").val();
        const hasta = $("#ventaHasta").val();

        $.get("modulos/reportes/ventas.php", { desde, hasta }, function (data) {
            // data SOLO debe contener <tr> de filas, no toda la tabla
            $("#tablaVentas").html(data);
        }).fail(() => alert("Error al cargar ventas"));
    });

    // Imprimir ventas
    $("#btnImprimirVentas").off("click").on("click", function () {
    const desde = $("#ventaDesde").val();
    const hasta = $("#ventaHasta").val();
    window.open(`modulos/reportes/ventas_imprimir.php?desde=${desde}&hasta=${hasta}`, '', 'width=800,height=600');
});


    // Buscar compras
    $("#btnBuscarCompras").off("click").on("click", function (e) {
        e.preventDefault();
        const desde = $("#compraDesde").val();
        const hasta = $("#compraHasta").val();

        $.get("modulos/reportes/compras.php", { desde, hasta }, function (data) {
            $("#tablaCompras").html(data);
        }).fail(() => alert("Error al cargar compras"));
    });

    // Imprimir compras
    $("#btnImprimirCompras").off("click").on("click", function () {
    const desde = $("#compraDesde").val();
    const hasta = $("#compraHasta").val();
    window.open(`modulos/reportes/compras_imprimir.php?desde=${desde}&hasta=${hasta}`, '', 'width=800,height=600');
});

    // Inventario
    $('button[data-bs-target="#inventario"]').off("click").on("click", function () {
        $("#tablaInventario").load("modulos/reportes/inventario.php");
    });

    // Ver detalle venta
    $(document).off("click", ".btnVerDetalle").on("click", ".btnVerDetalle", function () {
        const id = $(this).data("id");
        $.get("modulos/reportes/detalle_venta.php", { venta_id: id }, function (data) {
            $("#detalleVentaContent").html(data);
            modalVenta.show();
        });
    });

    // Ver detalle compra
    $(document).off("click", ".btnVerDetalleCompra").on("click", ".btnVerDetalleCompra", function () {
        const id = $(this).data("id");
        $.get("modulos/reportes/detalle_compra.php", { compra_id: id }, function (data) {
            $("#detalleCompraContent").html(data);
            modalCompra.show();
        });
    });

    // Función para imprimir
    function imprimirContenido(titulo, contenido) {
        let ventanaImpresion = window.open('', '', 'width=800,height=600');
        ventanaImpresion.document.write(`
            <html>
                <head>
                    <title>${titulo}</title>
                    <link rel="stylesheet" href="assets/css/style.css">
                </head>
                <body>
                    <h3 style="text-align:center;">${titulo}</h3>
                    ${contenido}
                </body>
            </html>
        `);
        ventanaImpresion.document.close();
        ventanaImpresion.focus();
        ventanaImpresion.print();
        ventanaImpresion.close();
    }
});

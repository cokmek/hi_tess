<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Compras y Ventas - Panel Principal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
    }
   #sidebar {
  height: 100vh;
  position: fixed;
  width: 220px;
  background-color: #343a40;
  z-index: 1030;
  top: 0;
  left: 0;
}
    #sidebar a {
      color: white;
      display: block;
      padding: 15px 20px;
      text-decoration: none;
    }
    #sidebar a:hover {
      background-color: #4b5661ff;
    }
   #content {
  margin-left: 220px;
  padding: 30px;
  margin-top: 70px; /* para dejar espacio debajo del header fijo */
}
#header {
  background: #007bff;
  color: white;
  padding: 10px 20px;
  position: fixed;
  width: calc(100% - 220px); /* todo menos el ancho del sidebar */
  margin-left: 220px;         /* justo después del sidebar */
  top: 0;
  z-index: 1040;
  display: flex;
  align-items: center;
  box-sizing: border-box;
  height: 110px;
}
#header img {
  height: 50px;        /* altura fija para banner */
  width: auto;
  max-width: 100%;
}

    #mainContent {
      margin-top: 70px;
    }
  </style>
</head>
<body>

  <div id="sidebar">
    <div class="text-center p-3 border-bottom">
      <img src="assets/img/logo.jpg" alt="Logo" style="max-width: 125px;" />
    </div>
    <a href="#" data-modulo="modulos/clientes/index.php">Clientes</a>
    <a href="#" data-modulo="modulos/productos/index.php">Productos</a>
    <a href="#" data-modulo="modulos/proveedores/index.php">Proveedores</a>
    <a href="#" data-modulo="modulos/compras/index.php">Compras</a>
    <a href="#" data-modulo="modulos/ventas/index.php">Ventas</a>
    <a href="#" data-modulo="modulos/reportes/index.php">Reportes</a>
  </div>

  <div id="header">
    <div style="width:100%; ">
      <img src="assets/img/baner2.png" alt="Banner" style="max-width:100%; height:auto;">
    </div>
  </div>

  <div id="content">
    <div id="mainContent">
      <h4>Bienvenido al sistema Compras y Ventas</h4>
      <p>Usa la barra lateral para navegar entre los módulos.</p>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(function () {
      $("#sidebar a").click(function (e) {
        e.preventDefault();
        var modulo = $(this).data("modulo");
        if (modulo) {
          $("#mainContent").html("<p>Cargando módulo...</p>");
          $("#sidebar a").css("pointer-events", "none");

          $("#mainContent").load(modulo, function () {
            // Determinar el nombre del JS del módulo
            var nombreModulo = modulo.split("/")[1]; // clientes, productos, etc.
            var jsModulo = "modulos/" + nombreModulo + "/" + nombreModulo + ".js";

            // Cargar el script del módulo
            $.getScript(jsModulo, function () {
              // Construir el nombre de la función inicializadora
              var nombreFuncion = "inicializarModulo" + nombreModulo.charAt(0).toUpperCase() + nombreModulo.slice(1);
              if (typeof window[nombreFuncion] === "function") {
                window[nombreFuncion]();
              }
            }).fail(function () {
              console.warn("No se encontró el archivo JS para el módulo: " + nombreModulo);
            }).always(function () {
              $("#sidebar a").css("pointer-events", "");
            });
          });
        }
      });
    });
  </script>

</body>
</html>


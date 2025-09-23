<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ÓPTICA ALFF</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
  <link rel="icon" href="vistas/img/plantilla/logo.png" type="image/png" />

  <!-- =========================
       CSS (orden correcto)
       ========================= -->
  <!-- Bootstrap 3.4.1 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />
  <!-- Font Awesome 4.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- Ionicons (si lo usas) -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css" />
  <!-- AdminLTE 2.4.18 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/AdminLTE.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/skins/skin-blue.min.css" />

  <!-- Plugins que realmente uses (sin duplicados) -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css" />
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css" />
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" />

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />

  <!-- Tu CSS personalizado -->
  <link rel="stylesheet" href="vistas/dist/css/custom.css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
<?php if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] === 'ok'): ?>
  <div class="wrapper">

    <?php
      // ============================
      // CABEZOTE (Header) y MENU
      // ============================
      require_once 'modulos/cabezote.php';   // <header class="main-header"> (una sola vez)
      require_once 'modulos/menu.php';
      //require_once 'modulos/inicio.php';       // <aside class="main-sidebar"> (una sola vez)

      // ============================
      // CONTENIDO
      // ============================
      $ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'inicio';
      $rutasPermitidas = [
        'inicio','usuarios','categorias','productos','clientes','ventas','crear-venta','editar-venta','reportes','historias','configuraciones','proveedores','salir'
      ];
      if (in_array($ruta, $rutasPermitidas, true)) {
        require_once 'modulos/'.$ruta.'.php';
      } else {
        require_once 'modulos/404.php';
      }

      // ============================
      // FOOTER
      // ============================
      require_once 'modulos/footer.php';
    ?>

  </div><!-- /.wrapper -->
<?php else: ?>
  <?php require_once 'modulos/login.php'; ?>
<?php endif; ?>

<!-- =========================
     JS (orden correcto y sin duplicados)
     ========================= -->
<!-- jQuery 2.2.4 (compatible con AdminLTE 2) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- Bootstrap 3.4.1 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- AdminLTE 2.4.18 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/js/adminlte.min.js"></script>

<!-- Plugins (solo una vez cada uno) -->
<script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
<script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
<script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
<script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script><!-- polyfill IE para SweetAlert2 si lo necesitas -->
<script src="vistas/plugins/iCheck/icheck.min.js"></script>
<script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
<script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>
<script src="vistas/bower_components/moment/min/moment.min.js"></script>
<script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="vistas/bower_components/raphael/raphael.min.js"></script>
<script src="vistas/bower_components/morris.js/morris.min.js"></script>
<script src="vistas/bower_components/Chart.js/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<!-- Bootstrap-select (si lo usas) -->
<link rel="stylesheet" href="vistas/plugins/boosel/bootstrap-select.min.css" />
<script src="vistas/plugins/boosel/bootstrap-select.min.js"></script>
<script src="vistas/plugins/boosel/default-es_ES.min.js"></script>

<!-- (Opcional) jQuery UI: incluye solo si realmente lo necesitas -->
<!--
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
-->

<!-- Scripts de tu app -->
<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/categorias.js"></script>
<script src="vistas/js/productos.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/entrega.js"></script>
<script src="vistas/js/reportes.js"></script>
<script src="vistas/js/proveedores.js"></script>
<script src="vistas/js/historias.js"></script>
<script src="vistas/js/configuraciones.js"></script>
<script src="vistas/js/alerta.js"></script>

<!-- Inicialización defensiva de componentes -->
<script>
  $(function () {
    // Dropdowns de Bootstrap
    $('.dropdown-toggle').dropdown();

    // Treeview del sidebar (AdminLTE 2)
    if ($.fn.tree) { $('.sidebar-menu').tree(); }

    // Persistencia del sidebar
    var key = 'lte2-sidebar-collapsed';
    var saved = localStorage.getItem(key);
    if (saved === '1') document.body.classList.add('sidebar-collapse');
    $(document).on('click', '[data-toggle="push-menu"]', function () {
      setTimeout(function () {
        localStorage.setItem(key, document.body.classList.contains('sidebar-collapse') ? '1' : '0');
      }, 150);
    });
  });
</script>
</body>
</html>

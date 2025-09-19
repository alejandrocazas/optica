<?php
// Ejemplo de variables de sesión usadas
// session_start(); // (si no lo tienes ya)
// $_SESSION["nombre"]   = $_SESSION["nombre"]   ?? "ALEJANDRO";
// $_SESSION["apellido"] = $_SESSION["apellido"] ?? "";
// $_SESSION["foto"]     = $_SESSION["foto"]     ?? "";
// $_SESSION["perfil"]   = $_SESSION["perfil"]   ?? "Administrador";

if ($_SESSION["perfil"] == "Especial") {
  echo '<script>window.location = "inicio";</script>';
  return;
}
$fecha_actual   = date("d-m-Y");
$nombre_usuario = $_SESSION["nombre"] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Óptica Oftalens</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">

  <!-- ====== AdminLTE 2 + Bootstrap 3 + FA4 ====== -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/AdminLTE.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">

  <!-- FullCalendar (para el widget) -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet"/>

  <style>
    /* Bienvenida */
    .bienvenida-box{
      background: linear-gradient(135deg,#00c6ff,#0072ff);
      color:#fff; text-align:center; padding:30px 10px;
      margin-bottom:30px; border-radius:15px;
    }
    .logo-optica{ font-size:22px; font-weight:700; margin-top:10px; }

    /* Cards de acceso rápido */
    .btn-modern{
      width:160px; height:160px; margin:20px auto; background:#fff;
      border-radius:20px; box-shadow:0 8px 16px rgba(0,0,0,.2);
      display:flex; flex-direction:column; justify-content:center; align-items:center;
      transition:all .3s ease; border:3px solid transparent;
    }
    .btn-modern i{ font-size:40px; color:#0072ff; margin-bottom:10px; }
    .btn-modern span{ font-size:16px; font-weight:700; color:#333; }
    .btn-modern:hover{ transform:translateY(-8px); border-color:#0072ff; }

    /* Calendario */
    #calendar{ height:350px; font-size:12px; }

    /* Ajuste sutil de brand en header */
    .main-header .navbar .navbar-brand{
      font-weight:600; color:#f4f6f9; background:transparent; padding:0 10px;
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- ===== HEADER (AdminLTE 2) ===== -->
  <header class="main-header">

    <!-- Logo -->
    <a href="inicio" class="logo">
      <span class="logo-mini"><b>O</b>O</span>
      <span class="logo-lg"><b>Óptica</b> Oftalens</span>
    </a>

    <!-- Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">

      <!-- Hamburguesa: abre/cierra el sidebar AdminLTE -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" aria-label="Abrir menú">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <!-- (Opcional) título centrado -->
      <span class="navbar-brand">Inicio</span>

      <!-- Derecha: Notificaciones + Usuario -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- 🔔 Notificaciones -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i>
              <?php
                $estado=null; $valorestado=null;
                $mostrarCount = ControladorCount::ctrMostrarCount($estado,$valorestado);
                $count = is_array($mostrarCount) ? count($mostrarCount) : 0;
                if ($count>0) echo '<span class="label label-danger">'.$count.'</span>';
              ?>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Notificaciones</li>
              <li>
                <ul class="menu" style="max-height:360px; overflow:auto">
                  <?php
                    $item=null; $valor=null;
                    $mostrarAlerta = ControladorAlerta::ctrMostrarAlerta($item,$valor);
                    if ($count>0 && is_array($mostrarAlerta)) {
                      foreach ($mostrarAlerta as $value) {
                        $autor   = htmlspecialchars($value["autor"]  ?? "");
                        $fecha   = htmlspecialchars($value["fecha"]  ?? "");
                        $mensaje = htmlspecialchars($value["mensaje"]?? "");
                        echo '<li>
                                <a href="#">
                                  <i class="fa fa-info-circle text-aqua"></i>
                                  <strong>'.$autor.'</strong>
                                  <small class="pull-right text-muted">'.$fecha.'</small><br>
                                  <span class="text-muted">'.$mensaje.'</span>
                                </a>
                              </li>';
                      }
                    } else {
                      echo '<li><a href="#"><span class="text-muted">No hay notificaciones</span></a></li>';
                    }
                  ?>
                </ul>
              </li>
              <li class="footer"><a href="reportes">Ver todas</a></li>
            </ul>
          </li>

          <!-- 👤 Usuario -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if (!empty($_SESSION["foto"])): ?>
                <img src="<?= htmlspecialchars($_SESSION["foto"]); ?>" class="user-image" alt="User Image">
              <?php else: ?>
                <img src="vistas/img/usuarios/default/anonymous.png" class="user-image" alt="User Image">
              <?php endif; ?>
              <span class="hidden-xs"><?= htmlspecialchars($_SESSION["nombre"]); ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <?php if (!empty($_SESSION["foto"])): ?>
                  <img src="<?= htmlspecialchars($_SESSION["foto"]); ?>" class="img-circle" alt="User Image">
                <?php else: ?>
                  <img src="vistas/img/usuarios/default/anonymous.png" class="img-circle" alt="User Image">
                <?php endif; ?>
                <p>
                  <?= htmlspecialchars($_SESSION["nombre"]." ".$_SESSION["apellido"]); ?>
                  <small>Usuario</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="usuarios" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-left" style="margin-left:10px">
                  <a href="configuraciones" class="btn btn-default btn-flat">Configuración</a>
                </div>
                <div class="pull-right">
                  <a href="salir" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- ===== SIDEBAR (AdminLTE 2 Treeview) ===== -->
  <aside class="main-sidebar">
    <section class="sidebar">

      <!-- Panel de usuario -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if (!empty($_SESSION["foto"])): ?>
            <img src="<?= htmlspecialchars($_SESSION["foto"]); ?>" class="img-circle" alt="User">
          <?php else: ?>
            <img src="vistas/img/usuarios/default/anonymous.png" class="img-circle" alt="User">
          <?php endif; ?>
        </div>
        <div class="pull-left info">
          <p><?= htmlspecialchars($_SESSION["nombre"]); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
        </div>
      </div>

      <?php
        // Helpers para 'active'
        function active($paths){
          $uri = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
          if (is_array($paths)) return in_array($uri,$paths)?'active':'';
          return ($uri === $paths)?'active':'';
        }
        $ventasActive = active(['ventas','reportes','reporte-excel']) ? 'active' : '';
        $ventasOpen   = $ventasActive ? 'menu-open' : '';
        $ventasStyle  = $ventasActive ? 'style="display:block"' : '';
      ?>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVEGACIÓN</li>

        <li class="<?= active('inicio'); ?>">
          <a href="inicio"><i class="fa fa-home"></i> <span>Inicio</span></a>
        </li>

        <!-- Ventas (treeview) -->
        <li class="treeview <?= $ventasActive.' '.$ventasOpen; ?>">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> <span>Ventas</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu" <?= $ventasStyle; ?>>
            <li class="<?= active('ventas'); ?>">
              <a href="ventas"><i class="fa fa-list"></i> Ver Ventas</a>
            </li>
            <li class="<?= active('reportes'); ?>">
              <a href="reportes"><i class="fa fa-bar-chart"></i> Estadísticas</a>
            </li>
            <li class="<?= active('reporte-excel'); ?>">
              <a href="reporte-excel"><i class="fa fa-file-excel-o"></i> Generar Excel</a>
            </li>
          </ul>
        </li>

        <li class="<?= active('productos'); ?>">
          <a href="productos"><i class="fa fa-product-hunt"></i> <span>Productos</span></a>
        </li>

        <li class="<?= active('clientes'); ?>">
          <a href="clientes"><i class="fa fa-users"></i> <span>Clientes</span></a>
        </li>

        <li class="<?= active('historias'); ?>">
          <a href="historias"><i class="fa fa-file-text-o"></i> <span>Historias</span></a>
        </li>

        <li class="<?= active('usuarios'); ?>">
          <a href="usuarios"><i class="fa fa-user-circle-o"></i> <span>Usuarios</span></a>
        </li>
      </ul>
    </section>
  </aside>

  <!-- ===== CONTENIDO (Inicio) ===== -->
  <div class="content-wrapper">

    <section class="content-header">
      <h1>Inicio <small>Bienvenido</small></h1>
    </section>

    <section class="content">
      <div class="bienvenida-box">
        <h3>BIENVENID@</h3>
        <h2><?= strtoupper($nombre_usuario); ?></h2>
        <div class="logo-optica"><?= strtoupper("Óptica Oftalens"); ?></div>
      </div>

      <div class="row">
        <div class="col-md-9">
          <div class="row text-center">
            <?php
              $modulos = [
                ["productos",    "fa-product-hunt",  "Productos"],
                ["crear-venta",  "fa-handshake-o",   "Crear Venta"],
                ["ventas",       "fa-shopping-cart", "Ventas"],
                ["clientes",     "fa-users",         "Clientes"],
                ["historias",    "fa-file-text-o",   "Historias"],
                ["usuarios",     "fa-user-circle-o", "Usuarios"]
              ];
              foreach ($modulos as $m) {
                echo '<div class="col-sm-4 col-xs-6">
                        <a href="'.$m[0].'">
                          <div class="btn-modern">
                            <i class="fa '.$m[1].'"></i>
                            <span>'.$m[2].'</span>
                          </div>
                        </a>
                      </div>';
              }
            ?>
          </div>
        </div>

        <div class="col-md-3">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-calendar"></i> Calendario</h3>
            </div>
            <div class="box-body">
              <div id="calendar"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div><!-- /.content-wrapper -->

  <footer class="main-footer text-sm">
    <div class="pull-right hidden-xs"><?= $fecha_actual; ?></div>
    <strong>Copyright &copy; <?= date('Y'); ?> Óptica Oftalens.</strong>
  </footer>
</div><!-- /.wrapper -->

<!-- ====== JS ====== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/js/adminlte.min.js"></script>

<!-- Persistir estado del sidebar (abierto/cerrado) -->
<script>
(function () {
  var key = 'lte2-sidebar-collapsed';
  var saved = localStorage.getItem(key);
  if (saved === '1') document.body.classList.add('sidebar-collapse');
  $(document).on('click', '[data-toggle="push-menu"]', function () {
    setTimeout(function () {
      var collapsed = document.body.classList.contains('sidebar-collapse');
      localStorage.setItem(key, collapsed ? '1' : '0');
    }, 150);
  });
})();
</script>

<!-- FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        contentHeight: 350,
        locale: 'es'
      });
      calendar.render();
    }
  });
</script>
</body>
</html>

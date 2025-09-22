<!-- ===== HEADER (AdminLTE 2) CORREGIDO ===== -->
<?php
$rutaActual = $_GET["ruta"] ?? "inicio";

$mapaTitulos = [
  "inicio" => "Panel principal",
  "usuarios" => "Usuarios",
  "categorias" => "Categorías",
  "productos" => "Productos",
  "clientes" => "Clientes",
  "ventas" => "Ventas",
  "crear-venta" => "Crear venta",
  "editar-venta" => "Editar venta",
  "reportes" => "Reportes",
  "historias" => "Historias clínicas",
  "configuraciones" => "Configuraciones",
  "proveedores" => "Proveedores",
];

$tituloSeccion = $mapaTitulos[$rutaActual] ?? ucwords(str_replace('-', ' ', $rutaActual));
$tituloSeccion = trim($tituloSeccion) !== '' ? $tituloSeccion : 'Panel principal';

$nombreSesion = $_SESSION["nombre"] ?? '';
$apellidoSesion = $_SESSION["apellido"] ?? '';
$nombreUsuario = trim($nombreSesion . ' ' . $apellidoSesion);
$nombreUsuario = $nombreUsuario !== '' ? $nombreUsuario : ($nombreSesion !== '' ? $nombreSesion : 'Usuario');
$perfilUsuario = $_SESSION["perfil"] ?? '';
$fotoUsuario = !empty($_SESSION["foto"]) ? $_SESSION["foto"] : 'vistas/img/usuarios/default/anonymous.png';

$estadoNotificacion = null;
$valorNotificacion = null;
$listadoNotificaciones = ControladorCount::ctrMostrarCount($estadoNotificacion, $valorNotificacion);
$totalNotificaciones = is_array($listadoNotificaciones) ? count($listadoNotificaciones) : 0;

$itemAlerta = null;
$valorAlerta = null;
$alertasCabecera = ControladorAlerta::ctrMostrarAlerta($itemAlerta, $valorAlerta);
$alertasCabecera = is_array($alertasCabecera) ? $alertasCabecera : [];
?>

<header class="main-header">

  <!-- Logo -->
  <a href="inicio" class="logo">
    <span class="logo-mini"><b>O</b>O</span>
    <span class="logo-lg"><b>Óptica</b> Oftalens</span>
  </a>

  <!-- Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">

    <!-- Botón hamburguesa: abre/cierra el sidebar AdminLTE -->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" aria-label="Abrir menú">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <!-- DERECHA: Notificaciones y Perfil -->
    <span class="navbar-page-title hidden-xs"><?= htmlspecialchars($tituloSeccion); ?></span>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <!-- 🔔 Notificaciones -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell"></i>
            <?php
              $estado = null; $valorestado = null;
              $mostrarCount = ControladorCount::ctrMostrarCount($estado, $valorestado);
              $count = is_array($mostrarCount) ? count($mostrarCount) : 0;
              if ($count > 0) echo '<span class="label label-danger">'.$count.'</span>';
            ?>
            <?php if ($totalNotificaciones > 0): ?>
              <span class="label label-danger"><?= (int) $totalNotificaciones; ?></span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu">
            <li class="header">Notificaciones</li>
            <li>
              <ul class="menu" style="max-height:360px; overflow:auto">
                <?php
                  $item = null; $valor = null;
                  $mostrarAlerta = ControladorAlerta::ctrMostrarAlerta($item, $valor);
                  if ($count > 0 && is_array($mostrarAlerta)) {
                    foreach ($mostrarAlerta as $value) {
                      $autor   = htmlspecialchars($value["autor"]   ?? '');
                      $fecha   = htmlspecialchars($value["fecha"]   ?? '');
                      $mensaje = htmlspecialchars($value["mensaje"] ?? '');
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
              <ul class="menu" style="max-height: 320px; overflow: auto;">
                <?php if ($totalNotificaciones > 0 && !empty($alertasCabecera)): ?>
                  <?php foreach ($alertasCabecera as $indice => $alerta): ?>
                    <?php if ($indice >= 6) { break; } ?>
                    <?php
                      $autor = htmlspecialchars($alerta['autor'] ?? 'Sistema');
                      $fecha = htmlspecialchars($alerta['fecha'] ?? '');
                      $mensaje = htmlspecialchars($alerta['mensaje'] ?? '');
                    ?>
                    <li>
                      <a href="#">
                        <i class="fa fa-info-circle text-aqua"></i>
                        <strong><?= $autor; ?></strong>
                        <small class="pull-right text-muted"><?= $fecha; ?></small><br>
                        <span class="text-muted"><?= $mensaje; ?></span>
                      </a>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li><a href="#"><span class="text-muted">No hay notificaciones</span></a></li>
                <?php endif; ?>
              </ul>
            </li>
            <li class="footer"><a href="reportes">Ver todas</a></li>
          </ul>
        </li>

        <!-- 👤 Perfil de usuario -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php if (!empty($_SESSION["foto"])): ?>
              <img src="<?= htmlspecialchars($_SESSION["foto"]); ?>" class="user-image" alt="User Image">
            <?php else: ?>
              <img src="vistas/img/usuarios/default/anonymous.png" class="user-image" alt="User Image">
            <?php endif; ?>
            <span class="hidden-xs"><?= htmlspecialchars($_SESSION["nombre"]); ?></span>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?= htmlspecialchars($fotoUsuario); ?>" class="user-image" alt="Foto de usuario">
            <span class="hidden-xs"><?= htmlspecialchars($nombreUsuario); ?></span>
          </a>

          <ul class="dropdown-menu">
            <!-- Cabecera usuario -->
            <li class="user-header">
              <?php if (!empty($_SESSION["foto"])): ?>
                <img src="<?= htmlspecialchars($_SESSION["foto"]); ?>" class="img-circle" alt="User Image">
              <?php else: ?>
                <img src="vistas/img/usuarios/default/anonymous.png" class="img-circle" alt="User Image">
              <?php endif; ?>
              <img src="<?= htmlspecialchars($fotoUsuario); ?>" class="img-circle" alt="Foto de usuario">
              <p>
                <?= htmlspecialchars($_SESSION["nombre"]." ".$_SESSION["apellido"]); ?>
                <small>Usuario</small>
                <?= htmlspecialchars($nombreUsuario); ?>
                <small><?= htmlspecialchars($perfilUsuario !== '' ? $perfilUsuario : 'Usuario'); ?></small>
              </p>
            </li>

            <!-- Pie -->
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
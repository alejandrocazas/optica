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

$accesosCabecera = [
  ["ruta" => "crear-venta", "icono" => "fa-handshake-o", "texto" => "Crear venta"],
  ["ruta" => "ventas", "icono" => "fa-line-chart", "texto" => "Reporte de ventas"],
  ["ruta" => "productos", "icono" => "fa-cubes", "texto" => "Inventario"],
  ["ruta" => "clientes", "icono" => "fa-id-card", "texto" => "Clientes"],
  ["ruta" => "historias", "icono" => "fa-eye", "texto" => "Historias"],
  ["ruta" => "configuraciones", "icono" => "fa-cog", "texto" => "Configuración"],
];

$nombreSesion = $_SESSION["nombre"] ?? '';
$apellidoSesion = $_SESSION["apellido"] ?? '';
$nombreUsuario = trim($nombreSesion . ' ' . $apellidoSesion);
$nombreUsuario = $nombreUsuario !== '' ? $nombreUsuario : ($nombreSesion ?: 'Usuario');
$perfilUsuario = $_SESSION["perfil"] ?? '';
$fotoUsuario = !empty($_SESSION["foto"]) ? $_SESSION["foto"] : 'vistas/img/usuarios/default/anonymous.png';

$estadoNotificacion = null;
$valorNotificacion = null;
$notificaciones = ControladorCount::ctrMostrarCount($estadoNotificacion, $valorNotificacion);
$totalNotificaciones = is_array($notificaciones) ? count($notificaciones) : 0;

$itemAlerta = null;
$valorAlerta = null;
$alertasCabecera = ControladorAlerta::ctrMostrarAlerta($itemAlerta, $valorAlerta);
if (!is_array($alertasCabecera)) {
  $alertasCabecera = [];
}
?>

<header class="main-header">

  <a href="inicio" class="logo">
    <span class="logo-mini"><b>O</b>O</span>
    <span class="logo-lg"><b>Óptica</b> Oftalens</span>
  </a>

  <nav class="navbar navbar-static-top" role="navigation">

    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" aria-label="Abrir menú">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <span class="navbar-section-title hidden-xs"><?= htmlspecialchars($tituloSeccion); ?></span>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <li class="dropdown quick-actions-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-th-large"></i>
          </a>
          <ul class="dropdown-menu">
            <li class="header">Accesos directos</li>
            <li>
              <div class="quick-actions-grid">
                <?php foreach ($accesosCabecera as $acceso): ?>
                  <a href="<?= htmlspecialchars($acceso['ruta']); ?>">
                    <i class="fa <?= htmlspecialchars($acceso['icono']); ?>"></i>
                    <span><?= htmlspecialchars($acceso['texto']); ?></span>
                  </a>
                <?php endforeach; ?>
              </div>
            </li>
          </ul>
        </li>

        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell"></i>
            <?php if ($totalNotificaciones > 0): ?>
              <span class="label label-danger"><?= (int) $totalNotificaciones; ?></span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu">
            <li class="header">Notificaciones</li>
            <li>
              <ul class="menu" style="max-height:360px; overflow:auto">
                <?php if ($totalNotificaciones > 0 && !empty($alertasCabecera)): ?>
                  <?php $limiteAlertas = 6; $indice = 0; ?>
                  <?php foreach ($alertasCabecera as $alertaCabecera): ?>
                    <?php if ($indice++ >= $limiteAlertas) { break; } ?>
                    <?php
                      $autor = htmlspecialchars($alertaCabecera['autor'] ?? '');
                      $fecha = htmlspecialchars($alertaCabecera['fecha'] ?? '');
                      $mensaje = htmlspecialchars($alertaCabecera['mensaje'] ?? '');
                    ?>
                    <li>
                      <a href="#">
                        <i class="fa fa-info-circle text-aqua"></i>
                        <strong><?= $autor !== '' ? $autor : 'Sistema'; ?></strong>
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

        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?= htmlspecialchars($fotoUsuario); ?>" class="user-image" alt="Foto de usuario">
            <span class="hidden-xs"><?= htmlspecialchars($nombreUsuario); ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="<?= htmlspecialchars($fotoUsuario); ?>" class="img-circle" alt="Foto de usuario">
              <p>
                <?= htmlspecialchars($nombreUsuario); ?>
                <small><?= htmlspecialchars($perfilUsuario !== '' ? $perfilUsuario : 'Usuario'); ?></small>
              </p>
            </li>
            <li class="user-body hidden-xs">
              <div class="row">
                <div class="col-xs-6 text-center">
                  <a href="configuraciones">Preferencias</a>
                </div>
                <div class="col-xs-6 text-center">
                  <a href="reportes">Reportes</a>
                </div>
              </div>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="usuarios" class="btn btn-default btn-flat">Perfil</a>
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

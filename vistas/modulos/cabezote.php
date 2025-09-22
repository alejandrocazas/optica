<!-- ===== HEADER (AdminLTE 2) CORREGIDO ===== -->
<?php
// Asegura la sesión iniciada en el bootstrap global.
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

// Ruta actual (sanitizada)
$rutaActualRaw = $_GET['ruta'] ?? 'inicio';
$rutaActual = preg_replace('~[^a-z0-9\-]~i', '', $rutaActualRaw);

$mapaTitulos = [
  'inicio'           => 'Panel principal',
  'usuarios'         => 'Usuarios',
  'categorias'       => 'Categorías',
  'productos'        => 'Productos',
  'clientes'         => 'Clientes',
  'ventas'           => 'Ventas',
  'crear-venta'      => 'Crear venta',
  'editar-venta'     => 'Editar venta',
  'reportes'         => 'Reportes',
  'historias'        => 'Historias clínicas',
  'configuraciones'  => 'Configuraciones',
  'proveedores'      => 'Proveedores',
];

$tituloSeccion = $mapaTitulos[$rutaActual] ?? ucwords(str_replace('-', ' ', $rutaActual));
$tituloSeccion = trim($tituloSeccion) !== '' ? $tituloSeccion : 'Panel principal';

$nombreSesion   = $_SESSION['nombre']   ?? '';
$apellidoSesion = $_SESSION['apellido'] ?? '';
$perfilUsuario  = $_SESSION['perfil']   ?? '';
$fotoUsuario    = !empty($_SESSION['foto']) ? $_SESSION['foto'] : 'vistas/img/usuarios/default/anonymous.png';
$nombreUsuario  = trim($nombreSesion.' '.$apellidoSesion);
if ($nombreUsuario === '') { $nombreUsuario = ($nombreSesion !== '' ? $nombreSesion : 'Usuario'); }

// Notificaciones: usa una única fuente para badge y listado
$alertasCabecera = ControladorAlerta::ctrMostrarAlerta(null, null);
$alertasCabecera = is_array($alertasCabecera) ? $alertasCabecera : [];
$totalNotificaciones = count($alertasCabecera);
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

    <!-- Título de la página -->
    <span class="navbar-page-title hidden-xs"><?= htmlspecialchars($tituloSeccion, ENT_QUOTES, 'UTF-8'); ?></span>

    <!-- DERECHA: Notificaciones y Perfil -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <!-- 🔔 Notificaciones -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell" aria-hidden="true"></i>
            <?php if ($totalNotificaciones > 0): ?>
              <span class="label label-danger"><?= (int)$totalNotificaciones; ?></span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu">
            <li class="header">Notificaciones</li>
            <li>
              <ul class="menu" style="max-height:360px; overflow:auto">
                <?php if ($totalNotificaciones > 0): ?>
                  <?php foreach ($alertasCabecera as $i => $alerta): ?>
                    <?php if ($i >= 6) break; // mostramos máx. 6 ?>
                    <?php
                      $autor   = htmlspecialchars($alerta['autor']   ?? 'Sistema', ENT_QUOTES, 'UTF-8');
                      $fecha   = htmlspecialchars($alerta['fecha']   ?? '', ENT_QUOTES, 'UTF-8');
                      $mensaje = htmlspecialchars($alerta['mensaje'] ?? '', ENT_QUOTES, 'UTF-8');
                    ?>
                    <li>
                      <a href="#">
                        <i class="fa fa-info-circle text-aqua" aria-hidden="true"></i>
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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?= htmlspecialchars($fotoUsuario, ENT_QUOTES, 'UTF-8'); ?>" class="user-image" alt="Foto de usuario">
            <span class="hidden-xs"><?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8'); ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- Cabecera usuario -->
            <li class="user-header">
              <img src="<?= htmlspecialchars($fotoUsuario, ENT_QUOTES, 'UTF-8'); ?>" class="img-circle" alt="Foto de usuario">
              <p>
                <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8'); ?>
                <small><?= htmlspecialchars($perfilUsuario !== '' ? $perfilUsuario : 'Usuario', ENT_QUOTES, 'UTF-8'); ?></small>
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

<!-- ===== HEADER (AdminLTE 2) CORREGIDO ===== -->
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
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <!-- 🔔 Notificaciones -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
            <?php
              $estado = null; $valorestado = null;
              $mostrarCount = ControladorCount::ctrMostrarCount($estado, $valorestado);
              $count = is_array($mostrarCount) ? count($mostrarCount) : 0;
              if ($count > 0) echo '<span class="label label-danger">'.$count.'</span>';
            ?>
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
          </a>

          <ul class="dropdown-menu">
            <!-- Cabecera usuario -->
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


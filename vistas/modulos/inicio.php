<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
if (empty($_SESSION['nombre'])) { header('Location: login'); exit; }

$fecha_actual   = date('d-m-Y');
$nombre_usuario = $_SESSION['nombre'] ?? '';
$apellido       = $_SESSION['apellido'] ?? '';
function mb_ucase($s){ return mb_strtoupper($s, 'UTF-8'); }
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Inicio <small>Bienvenido</small></h1>
  </section>

  <section class="content">
    <style>
      .bienvenida-box{
        background: linear-gradient(135deg,#00c6ff,#0072ff);
        color:#fff; text-align:center; padding:30px 10px;
        margin-bottom:30px; border-radius:15px;
      }
      .btn-modern{
        width:160px; height:160px; margin:20px auto; background:#fff;
        border-radius:20px; box-shadow:0 8px 16px rgba(0,0,0,.2);
        display:flex; flex-direction:column; justify-content:center; align-items:center;
        transition:all .3s ease; border:3px solid transparent;
      }
      .btn-modern i{ font-size:40px; }
      .btn-modern span{ font-size:16px; font-weight:700; color:#333; }
      .btn-modern:hover{ transform:translateY(-8px); border-color:#0072ff; }
      #calendar{ height:350px; font-size:12px; }
    </style>

    <div class="bienvenida-box">
      <h3>BIENVENID@</h3>
      <h2><?= htmlspecialchars(mb_ucase($nombre_usuario), ENT_QUOTES, 'UTF-8'); ?></h2>
      <div class="logo-optica"><?= htmlspecialchars(mb_ucase('Óptica Oftalens'), ENT_QUOTES, 'UTF-8'); ?></div>
    </div>

    <div class="row">
      <div class="col-md-9">
        <div class="row text-center">
          <?php
            $modulos = [
              ['productos','fa-product-hunt','Productos'],
              ['crear-venta','fa-handshake-o','Crear Venta'],
              ['ventas','fa-shopping-cart','Ventas'],
              ['clientes','fa-users','Clientes'],
              ['historias','fa-file-text-o','Historias'],
              ['usuarios','fa-user-circle-o','Usuarios'],
            ];
            foreach ($modulos as $m):
          ?>
            <div class="col-sm-4 col-xs-6">
              <a href="<?= htmlspecialchars($m[0], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="btn-modern" role="button" aria-label="Ir a <?= htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8'); ?>">
                  <i class="fa <?= htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8'); ?>"></i>
                  <span><?= htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-md-3">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-calendar"></i> Calendario</h3>
          </div>
          <div class="box-body">
            <div id="calendar" aria-label="Calendario de citas y eventos"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  // Si ya cargas FullCalendar en plantilla.php, esto basta:
  document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('calendar');
    if (!el || typeof FullCalendar === 'undefined') return;
    var calendar = new FullCalendar.Calendar(el, {
      initialView: 'dayGridMonth',
      contentHeight: 350,
      locale: 'es'
    });
    calendar.render();
  });
</script>

<?php
setlocale(LC_TIME, 'es_ES.UTF-8'); // Para entornos Linux
// Para Windows, puedes probar con: setlocale(LC_TIME, 'spanish');
date_default_timezone_set('America/La_Paz'); // Ajustar a tu zona horaria

$fechaActual = strftime('%A %e de %B de %Y');
$fechaActual = ucfirst($fechaActual); // Primera letra en mayúscula
?>

<footer class="main-footer text-center">
  <strong>
    Copyright &copy; <?php echo date("Y"); ?>, soporte:
    <a href="https://wa.me/59175839845" target="_blank">Dev.Alejandro C.</a>.
  </strong>
  <br>
  <small><?php echo $fechaActual; ?></small>
</footer>
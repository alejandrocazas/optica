<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Óptica Oftalens | Iniciar sesión</title>

  <!-- Bootstrap 3.3.7 (conservado para compatibilidad con tu proyecto) -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css" />
  <!-- Fuente -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; }

    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Poppins', 'Segoe UI', sans-serif;
      color: #101b37;
      background:
        radial-gradient(circle at top left, rgba(0, 114, 255, 0.18), transparent 60%),
        radial-gradient(circle at bottom right, rgba(0, 198, 255, 0.2), transparent 55%),
        #f4f7fb;
    }

    .login-wrapper {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 32px 16px;
    }

    .login-card {
      width: 100%;
      max-width: 960px;
      background: #ffffff;
      border-radius: 28px;
      box-shadow: 0 35px 70px rgba(15, 40, 120, 0.18);
      display: flex;
      overflow: hidden;
      position: relative;
    }

    .card-visual {
      flex: 1.1;
      position: relative;
      background: linear-gradient(135deg, rgba(0, 114, 255, 0.9), rgba(0, 198, 255, 0.85));
      display: flex;
      align-items: stretch;
      justify-content: center;
      color: #fff;
      min-height: 260px;
    }

    .card-visual::before {
      content: "";
      position: absolute;
      inset: 0;
      background: url('vistas/img/plantilla/portada.jpg') center/cover no-repeat;
      opacity: 0.35;
    }

    .visual-content {
      position: relative;
      z-index: 1;
      padding: 48px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 28px;
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-size: 15px;
      font-weight: 600;
      letter-spacing: .6px;
      text-transform: uppercase;
      background: rgba(255, 255, 255, 0.18);
      border-radius: 20px;
      padding: 10px 18px;
      box-shadow: 0 10px 22px rgba(6, 12, 40, 0.18);
    }

    .visual-content h3 {
      font-size: 30px;
      font-weight: 700;
      margin: 0;
      line-height: 1.25;
    }

    .visual-content p { font-size: 15px; margin: 0; opacity: .9; }

    .visual-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: grid;
      gap: 14px;
      font-family: 'Segoe UI', sans-serif;
    }

    .visual-list li { display: flex; align-items: center; gap: 10px; font-size: 14px; }

    .visual-list i {
      font-size: 16px;
      background: rgba(255, 255, 255, 0.22);
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .card-form {
      flex: 1;
      background: #fff;
      padding: 48px 56px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }

    .brand-logo {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 68px;
      height: 68px;
      border-radius: 18px;
      background: linear-gradient(135deg, rgba(0, 114, 255, 0.12), rgba(0, 198, 255, 0.18));
      color: #0072ff;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 24px;
    }

    .card-form h2 { margin: 0; font-weight: 700; font-size: 30px; color: #0f1c2d; }
    .card-form .subtitle { margin: 10px 0 26px; color: #6d778a; font-size: 14px; }

    .form-field { position: relative; margin-bottom: 18px; }

    .form-field label { font-size: 13px; font-weight: 600; color: #596680; display: block; margin-bottom: 6px; }

    .field-icon {
      position: absolute;
      top: 50%;
      left: 16px;
      transform: translateY(-50%);
      color: #0072ff;
      font-size: 16px;
      pointer-events: none;
    }

    .form-field input {
      width: 100%;
      border: 1px solid #dce3f0;
      border-radius: 14px;
      padding: 14px 16px 14px 44px;
      font-size: 15px;
      transition: all .25s ease;
      height: 50px;
    }

    .form-field input:focus {
      border-color: #0072ff;
      outline: none;
      box-shadow: 0 0 0 4px rgba(0, 114, 255, 0.12);
    }

    .btn-login {
      border: none;
      border-radius: 16px;
      padding: 15px;
      margin-top: 6px;
      font-size: 16px;
      font-weight: 600;
      color: #fff;
      width: 100%;
      background: linear-gradient(135deg, #0072ff, #00c6ff);
      box-shadow: 0 15px 30px rgba(0, 114, 255, 0.25);
      transition: transform .2s ease, box-shadow .2s ease;
    }

    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 20px 38px rgba(0, 114, 255, 0.3); }

    .support-links { margin-top: 24px; display: flex; justify-content: space-between; gap: 12px; font-size: 13px; }
    .support-links a { color: #0072ff; font-weight: 600; text-decoration: none; transition: color .2s ease; }
    .support-links a:hover { color: #004a9f; }

    .footer-note { margin-top: 26px; font-size: 12px; color: #8a93a6; text-align: center; }

    @media (max-width: 992px) { .login-card { flex-direction: column; } .card-form { padding: 40px 32px; } }
    @media (max-width: 576px) { .card-form { padding: 36px 24px; } .support-links { flex-direction: column; align-items: flex-start; } }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <!-- Panel visual izquierdo -->
      <div class="card-visual">
        <div class="visual-content">
          <span class="brand-badge"><i class="fa fa-eye"></i> Óptica Oftalens</span>
          <div>
            <h3>Cuida la visión de tus pacientes y el crecimiento de tu negocio</h3>
            <p>Administra ventas, historias clínicas y control de inventario en una sola plataforma moderna.</p>
          </div>
          <ul class="visual-list">
            <li><i class="fa fa-check"></i> Recordatorios de entregas y citas</li>
            <li><i class="fa fa-check"></i> Control de stock e informes en tiempo real</li>
            <li><i class="fa fa-check"></i> Accesos personalizados para tu equipo</li>
          </ul>
        </div>
      </div>

      <!-- Panel de formulario derecho -->
      <div class="card-form">
        <div class="brand-logo">OO</div>
        <h2 id="loginSaludo">Bienvenido</h2>
        <p class="subtitle">Ingresa tus credenciales para acceder al panel administrativo.</p>

        <!-- Formulario único (sin formularios anidados) -->
        <form method="post" class="login-form" action=""> <!-- coloca aquí la ruta deseada -->
          <!-- SUGERENCIA: agrega un CSRF server-side -->
          <!-- <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"> -->

          <div class="form-field">
            <label for="ingUsuario">Usuario o correo electrónico</label>
            <span class="field-icon"><i class="fa fa-user"></i></span>
            <input type="text" id="ingUsuario" name="ingUsuario" placeholder="ej. admin@empresa.com" required autocomplete="username" />
          </div>

          <div class="form-field">
            <label for="ingPassword">Contraseña</label>
            <span class="field-icon"><i class="fa fa-lock"></i></span>
            <input type="password" id="ingPassword" name="ingPassword" placeholder="Ingresa tu contraseña" required autocomplete="current-password" />
          </div>

          <button type="submit" class="btn btn-login">Ingresar</button>

          <div class="support-links">
            <a href="https://wa.me/59175839845" target="_blank" rel="noopener">¿Olvidaste tu contraseña?</a>
            <a href="https://wa.me/59175839845" target="_blank" rel="noopener">Contactar soporte</a>
          </div>

          <p class="footer-note">© <?php echo date('Y'); ?> Óptica Oftalens. Todos los derechos reservados.</p>
        </form>

        <!-- Controlador PHP (un solo llamado) -->
        <?php
          // Asegúrate de tener autoload y controlador incluidos antes
          // require_once 'ruta/a/ControladorUsuarios.php';
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = new ControladorUsuarios();
            // Valida y sanea datos antes de pasarlos
            $_POST['ingUsuario'] = trim($_POST['ingUsuario'] ?? '');
            $_POST['ingPassword'] = $_POST['ingPassword'] ?? '';
            $login->ctrIngresoUsuario();
          }
        ?>
      </div>
    </div>
  </div>

  <!-- Script de saludo dinámico (único) -->
  <script>
    (function () {
      var saludo = document.getElementById('loginSaludo');
      if (!saludo) return;
      var hora = new Date().getHours();
      var mensaje = (hora < 12) ? 'Buenos días' : (hora < 18) ? 'Buenas tardes' : 'Buenas noches';
      saludo.textContent = mensaje;
    })();
  </script>

  <!-- JS opcional de Bootstrap (si necesitas componentes JS de BS3) -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

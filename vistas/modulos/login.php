<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login | </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Estilos personalizados -->
  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .container-login {
      display: flex;
      height: 100vh;
      width: 100vw;
    }

    .left-img {
      flex: 1;
      background-image: url('vistas/img/plantilla/portada.jpg'); /* Cambia la ruta según tu imagen */
      background-size: cover;
      background-position: center;
    }

    .right-form {
      flex: 1;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .login-box {
      width: 100%;
      max-width: 350px;
    }

    .logo-login {
      width: 200px;
      margin-bottom: 30px;
    }

    .form-control {
      height: 45px;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    .btn-login {
      background-color:rgb(117, 223, 67);
      color: #fff;
      border: none;
      border-radius: 6px;
      height: 45px;
      font-weight: bold;
      width: 100%;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color:rgb(72, 219, 133);
    }

    .link {
      display: block;
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
      color: #555;
    }

    .link:hover {
      color: #000;
    }

    @media screen and (max-width: 768px) {
      .container-login {
        flex-direction: column;
      }

      .left-img {
        height: 200px;
      }
    }
  </style>
</head>
<body>

<div class="container-login">

  <div class="left-img">
    <!-- Imagen se adapta con CSS -->
  </div>

  <div class="right-form">
    <div class="login-box">

      <!-- LOGO -->
      <div class="text-center">
        <h3 id="mensajeBienvenida" style="margin-bottom: 30px; font-weight: bold; color: #333;"></h3>
        <!--<img src="vistas/img/plantilla/logo1.png" class="logo-login">-->
      </div>

      <!-- FORMULARIO -->
      <form method="post">

        <input type="text" class="form-control" name="ingUsuario" placeholder="Usuario o email" required>

        <input type="password" class="form-control" name="ingPassword" placeholder="Clave" required>

        <button type="submit" class="btn btn-login">ENTRAR</button>

        <a class="link" href="https://wa.me/59175839845">¿Olvidaste tu contraseña?</a>
        <a class="link" href="https://wa.me/59175839845">Solicitar más información</a>

        <?php
          $login = new ControladorUsuarios();
          $login -> ctrIngresoUsuario();
        ?>

      </form>

    </div>
  </div>

</div>
<!-- JavaScript para mensaje dinámico -->
<script>
  const hora = new Date().getHours();
  const mensajeEl = document.getElementById('mensajeBienvenida');
  let saludo = "";

  if (hora < 12) {
    saludo = "🌞 Buenos días";
  } else if (hora < 18) {
    saludo = "🌤️ Buenas tardes";
  } else {
    saludo = "🌙 Buenas noches";
  }

  mensajeEl.textContent = saludo + ", por favor inicie sesión";
</script>

</body>
</html>

<?php
session_start();


if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header("Location: ../../index.php?controlador=menu&accion=index");
    exit();
}


$error_mensaje = isset($_SESSION['error_login']) ? $_SESSION['error_login'] : '';
unset($_SESSION['error_login']);


$usuario_recordado = isset($_COOKIE['recordar_usuario']) ? $_COOKIE['recordar_usuario'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-signin {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .form-signin h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            margin-bottom: 15px;
        }

        .form-signin button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .form-signin button:hover {
            background-color: #0056b3;
        }

        .text-muted {
            font-size: 0.9rem;
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="text-center">

<main class="form-signin">
    <!-- Logo -->
    <div class="logo">
        <img src="../assets/logo.png" alt="Logo VitalFit">
    </div>


    <?php if (!empty($error_mensaje)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_mensaje; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="../../Controladores/InicioSesionControlador.php">
        <h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="usuario" placeholder="Usuario" value="<?php echo $usuario_recordado; ?>" required>
            <label for="floatingInput">Usuario</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" name="contrasena" placeholder="Contraseña" required>
            <label for="floatingPassword">Contraseña</label>
        </div>

        <div class="checkbox mb-3 text-start">
            <label>
                <input type="checkbox" value="recordar" name="recordar" <?php echo !empty($usuario_recordado) ? 'checked' : ''; ?>> Recordar usuario
            </label>
            <br>
            <a href="#" class="text-muted">¿Olvidó su contraseña?</a>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Ingresar</button>
        <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?> VitalFit</p>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
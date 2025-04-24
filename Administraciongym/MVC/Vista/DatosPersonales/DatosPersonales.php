<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VitalFit - Datos Personales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #003366;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar-brand img {
            margin-right: 10px;
        }

        .container {
            margin-top: 40px;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-volver, .btn-salir {
            margin-top: 25px;
            margin-right: 10px;
        }

        h2 {
            color: #003366;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="./assets/logo.png" alt="Logo" width="30" height="30">
        VitalFit
    </a>
</nav>

<div class="container">
    <h2 class="mb-4">Datos Personales</h2>

    <form action="../../Controladores/UsuarioControlador.php" method="post">
        <div class="mb-3">
            <label for="id_usuario" class="form-label">ID del Usuario</label>
            <input type="text" class="form-control" id="id_usuario" name="id_usuario" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido1" class="form-label">Primer Apellido</label>
            <input type="text" class="form-control" id="apellido1" name="apellido1" required>
        </div>
        <div class="mb-3">
            <label for="apellido2" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control" id="apellido2" name="apellido2">
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección Residencial</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <button type="submit" name="accion" value="guardar" class="btn btn-primary">Guardar Datos</button>
    </form>

    <div class="mt-4">
        <a href="../../index.php" class="btn btn-secondary btn-volver">Regresar al Menú Principal</a>
        <a href="../../index.php" class="btn btn-danger btn-salir">Salir de la Sesión</a>
    </div>
</div>

</body>
</html>

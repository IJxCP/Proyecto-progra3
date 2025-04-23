<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VitalFit - Control de Mantenimiento</title>
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
    <h2 class="mb-4">Control de Mantenimiento</h2>

    <form action="../../Controladores/MantenimientoControlador.php" method="post">
        <div class="mb-3">
            <label for="fecha_mantenimiento" class="form-label">Fecha de Mantenimiento</label>
            <input type="date" class="form-control" id="fecha_mantenimiento" name="fecha_mantenimiento" required>
        </div>
        <div class="mb-3">
            <label for="responsable" class="form-label">Responsable</label>
            <input type="text" class="form-control" id="responsable" name="responsable" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción del Mantenimiento</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="mb-3">
            <label for="estado_equipos" class="form-label">Estado de los Equipos</label>
            <input type="text" class="form-control" id="estado_equipos" name="estado_equipos" required>
        </div>
        <button type="submit" name="accion" value="guardar" class="btn btn-primary">Guardar Información</button>
    </form>

    <div class="mt-4">
        <a href="../../index.php" class="btn btn-secondary btn-volver">Regresar al Menú Principal</a>
        <a href="../../index.php" class="btn btn-danger btn-salir">Salir de la Sesión</a>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VitalFit - Registro de Cliente</title>
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
    <script>
        function mostrarOtroObjetivo() {
            var objetivos = document.getElementById("objetivos");
            var otroObjetivoDiv = document.getElementById("otroObjetivoDiv");
            if (objetivos.value === "otro") {
                otroObjetivoDiv.style.display = "block";
            } else {
                otroObjetivoDiv.style.display = "none";
            }
        }
    </script>
</head>
<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="./assets/logo.png" alt="Logo" width="30" height="30">
        VitalFit
    </a>
</nav>

<div class="container">
    <h2 class="mb-4">Registro de Cliente</h2>

    <form action="../../Controladores/ClienteControlador.php" method="post">
        <div class="mb-3">
            <label for="id_cliente" class="form-label">ID del Cliente</label>
            <input type="text" class="form-control" id="id_cliente" name="id_cliente" required>
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
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
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
        <div class="mb-3">
            <label for="objetivos" class="form-label">Objetivos</label>
            <select class="form-control" id="objetivos" name="objetivos" onchange="mostrarOtroObjetivo()" required>
                <option value="perdida_grasa">Pérdida de grasa</option>
                <option value="hipertrofia">Hipertrofia</option>
                <option value="acondicionamiento_fisico_general">Acondicionamiento físico general</option>
                <option value="otro">Otro</option>
            </select>
        </div>
        <div class="mb-3" id="otroObjetivoDiv" style="display: none;">
            <label for="otro_objetivo" class="form-label">Explicación del Objetivo</label>
            <input type="text" class="form-control" id="otro_objetivo" name="otro_objetivo">
        </div>
        <div class="mb-3">
            <label for="notas" class="form-label">Notas Generales</label>
            <textarea class="form-control" id="notas" name="notas"></textarea>
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

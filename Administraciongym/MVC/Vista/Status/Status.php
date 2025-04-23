<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VitalFit - Control de Status del Cliente</title>
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
        function mostrarNombreCliente() {
            var idCliente = document.getElementById("id_cliente").value;
            // Aquí deberías implementar la lógica para extraer el nombre del cliente según el ID
            // Por ejemplo, podrías hacer una llamada AJAX a tu servidor para obtener el nombre del cliente
            // y luego actualizar el campo de nombre del cliente.
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
    <h2 class="mb-4">Control de Status del Cliente</h2>

    <form action="../../Controladores/StatusClienteControlador.php" method="post">
        <div class="mb-3">
            <label for="id_cliente" class="form-label">ID del Cliente</label>
            <input type="text" class="form-control" id="id_cliente" name="id_cliente" required oninput="mostrarNombreCliente()">
        </div>
        <div class="mb-3">
            <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" readonly>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
                <option value="Suspendido">Suspendido</option>
            </select>
        </div>
        <div class="mb-3">
            <label ="notas" class="form-label">Notas Generales</label>
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

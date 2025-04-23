<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VitalFit - Gestión de Stock</title>
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
    <h2 class="mb-4">Gestión de Stock</h2>

    <form action="../../Controladores/StockControlador.php" method="post">
        <div class="mb-3">
            <label for="producto" class="form-label">Nombre del producto</label>
            <input type="text" class="form-control" id="producto" name="producto" required>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="categoria" name="categoria">
        </div>
        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación en bodega</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion">
        </div>
        <button type="submit" name="accion" value="guardar" class="btn btn-primary">Guardar Producto</button>
    </form>

    <div class="mt-4">
        <a href="javascript:history.back()" class="btn btn-secondary btn-volver">← Regresar</a>
        <a href="../../index.php" class="btn btn-danger btn-salir">Salir</a>
    </div>
</div>

</body>
</html>

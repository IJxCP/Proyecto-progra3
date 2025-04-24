<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VitalFit - Gestión de Cuotas</title>
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
        function mostrarComprobante() {
            var estado = document.getElementById("estado").value;
            var comprobanteDiv = document.getElementById("comprobanteDiv");
            if (estado === "pagado") {
                comprobanteDiv.style.display = "block";
            } else {
                comprobanteDiv.style.display = "none";
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
    <h2 class="mb-4">Gestión de Cuotas</h2>

    <form action="../../Controladores/CuotasControlador.php" method="post">
        <div class="mb-3">
            <label for="id_cliente" class="form-label">ID del Cliente</label>
            <input type="text" class="form-control" id="id_cliente" name="id_cliente" required>
        </div>
        <div class="mb-3">
            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
        </div>
        <div class="mb-3">
            <label for="monto" class="form-label">Monto a Pagar</label>
            <input type="number" class="form-control" id="monto" name="monto" required>
        </div>
        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de Pago</label>
            <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="SINPE">SINPE</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado de la Mensualidad</label>
            <select class="form-control" id="estado" name="estado" onchange="mostrarComprobante()" required>
                <option value="pagado">Pagado</option>
                <option value="pendiente">Pendiente</option>
                <option value="atrasado">Atrasado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
        </div>
        <div class="mb-3" id="comprobanteDiv" style="display: none;">
            <label for="comprobante" class="form-label">Número del Comprobante de Pago</label>
            <input type="text" class="form-control" id="comprobante" name="comprobante">
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

<?php
// Verificar autenticación
require_once $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
UsuarioControlador::verificarAutenticacion();

// Incluir el modelo de inscripciones para cargar la lista de inscripciones
require_once 'MVC/Modelo/InscripcionM.php';
$inscripcionModelo = new InscripcionM();
$inscripciones = $inscripcionModelo->BuscarTodos();

// Si se ha especificado un ID de inscripción en la URL, obtenerlo
$idInscripcion = isset($_GET['idinscripcion']) ? $_GET['idinscripcion'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Registrar Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        }

        .form-label {
            font-weight: bold;
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

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="MVC/Vista/assets/logo.png" alt="Logo" width="30" height="30">
            VitalFit
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controlador=menu">
                        <i class="fas fa-home"></i> Menú Principal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controlador=usuario&accion=cerrarSesion">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Registrar Pago</h2>
        <a href="index.php?controlador=cuota&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <form action="index.php?controlador=cuota&accion=guardar" method="post">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="idinscripcion" class="form-label">Inscripción/Cliente *</label>
                <select class="form-select" id="idinscripcion" name="idinscripcion" required>
                    <option value="">Seleccione una inscripción</option>
                    <?php if (isset($inscripciones) && is_array($inscripciones) && count($inscripciones) > 0): ?>
                        <?php foreach ($inscripciones as $inscripcion): ?>
                            <?php
                            // Si se pasó un ID de inscripción específico, seleccionarlo
                            $selected = isset($idInscripcion) && $idInscripcion == $inscripcion->getId() ? 'selected' : '';
                            $nombreCliente = $inscripcion->getNombreCliente();
                            $fechaVencimiento = date('d/m/Y', strtotime($inscripcion->getFechaVencimiento()));
                            $tipoMembresia = ucfirst($inscripcion->getTipoMembresia());
                            ?>
                            <option value="<?php echo $inscripcion->getId(); ?>" <?php echo $selected; ?>>
                                <?php echo "Cliente: " . htmlspecialchars($nombreCliente) . " - " . $tipoMembresia . " (Vence: " . $fechaVencimiento . ")"; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <div class="form-text">
                    <a href="index.php?controlador=inscripcion&accion=crear" target="_blank">
                        <i class="fas fa-plus-circle"></i> Registrar nueva inscripción
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fechapago" class="form-label">Fecha de Pago *</label>
                <input type="date" class="form-control" id="fechapago" name="fechapago" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="monto" class="form-label">Monto (₡) *</label>
                <input type="number" class="form-control" id="monto" name="monto" min="0" step="1000" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="metodopago" class="form-label">Método de Pago *</label>
                <select class="form-select" id="metodopago" name="metodopago" required>
                    <option value="">Seleccione un método</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="SINPE">SINPE Móvil</option>
                    <option value="transferencia">Transferencia Bancaria</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="estado" class="form-label">Estado del Pago *</label>
                <select class="form-select" id="estado" name="estado" onchange="mostrarComprobante()" required>
                    <option value="pagado">Pagado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="atrasado">Atrasado</option>
                </select>
            </div>
        </div>

        <div class="mb-3" id="comprobanteDiv">
            <label for="comprobante" class="form-label">Número de Comprobante</label>
            <input type="text" class="form-control" id="comprobante" name="comprobante" placeholder="Número de comprobante o referencia">
            <div class="form-text">Opcional. Ingresar número de comprobante, voucher o referencia del pago.</div>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button type="reset" class="btn btn-outline-secondary me-md-2">Limpiar Formulario</button>
            <button type="submit" class="btn btn-primary">Registrar Pago</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mostrar/ocultar campo de comprobante al cargar la página
    window.onload = function() {
        mostrarComprobante();
    };
</script>
</body>
</html>
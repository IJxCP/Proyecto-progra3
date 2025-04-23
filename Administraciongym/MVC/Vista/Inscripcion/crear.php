<?php
// Verificar autenticación
echo "BASE_PATH definido: " . (defined('BASE_PATH') ? 'Sí' : 'No') . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . __FILE__ . "<br>";

// Intenta esta ruta absoluta
$rutaUsuarioControlador = $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
echo "Ruta a probar: " . $rutaUsuarioControlador . "<br>";
echo "El archivo existe: " . (file_exists($rutaUsuarioControlador) ? 'Sí' : 'No') . "<br>";

// Si el archivo existe, entonces inclúyelo
if (file_exists($rutaUsuarioControlador)) {
    require_once $rutaUsuarioControlador;
    UsuarioControlador::verificarAutenticacion();
} else {
    echo "No se pudo encontrar el archivo UsuarioControlador.php";
    // Continuar con el resto del código para que la página cargue y puedas ver los mensajes
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Nueva Inscripción</title>
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
        function calcularFechaVencimiento() {
            const fechaInscripcion = document.getElementById('fechainscripcion').value;
            const tipoMembresia = document.getElementById('tipomembresia').value;

            if (!fechaInscripcion || !tipoMembresia) return;

            const fecha = new Date(fechaInscripcion);

            switch (tipoMembresia) {
                case 'mensual':
                    fecha.setMonth(fecha.getMonth() + 1);
                    break;
                case 'trimestral':
                    fecha.setMonth(fecha.getMonth() + 3);
                    break;
                case 'semestral':
                    fecha.setMonth(fecha.getMonth() + 6);
                    break;
                case 'anual':
                    fecha.setFullYear(fecha.getFullYear() + 1);
                    break;
            }

            const fechaFormateada = fecha.toISOString().split('T')[0];
            document.getElementById('fechavencimiento').value = fechaFormateada;
        }

        function establecerMontoSugerido() {
            const tipoMembresia = document.getElementById('tipomembresia').value;
            let montoSugerido = 0;

            switch (tipoMembresia) {
                case 'mensual':
                    montoSugerido = 25000;
                    break;
                case 'trimestral':
                    montoSugerido = 65000;
                    break;
                case 'semestral':
                    montoSugerido = 120000;
                    break;
                case 'anual':
                    montoSugerido = 200000;
                    break;
            }

            document.getElementById('monto').value = montoSugerido;
        }

        function actualizarFechaYMonto() {
            calcularFechaVencimiento();
            establecerMontoSugerido();
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
        <h2>Nueva Inscripción</h2>
        <a href="index.php?controlador=inscripcion&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <form action="index.php?controlador=inscripcion&accion=guardar" method="post">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="idgestiondatos" class="form-label">Cliente *</label>
                <select class="form-select" id="idgestiondatos" name="idgestiondatos" required>
                    <option value="">Seleccione un cliente</option>
                    <?php if (isset($clientes) && is_array($clientes) && count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <?php
                            // Si se pasó un ID de cliente específico, seleccionarlo
                            $selected = isset($idCliente) && $idCliente == $cliente->getId() ? 'selected' : '';
                            $nombreCompleto = $cliente->getNombreCompleto();
                            $idGestionDatos = isset($cliente->idGestionDatos) ? $cliente->idGestionDatos : 0;
                            ?>
                            <option value="<?php echo $idGestionDatos; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($nombreCompleto); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <div class="form-text">
                    <a href="index.php?controlador=cliente&accion=crear" target="_blank">
                        <i class="fas fa-plus-circle"></i> Registrar nuevo cliente
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fechainscripcion" class="form-label">Fecha de Inscripción *</label>
                <input type="date" class="form-control" id="fechainscripcion" name="fechainscripcion" value="<?php echo date('Y-m-d'); ?>" required onchange="calcularFechaVencimiento()">
            </div>
            <div class="col-md-6">
                <label for="tipomembresia" class="form-label">Tipo de Membresía *</label>
                <select class="form-select" id="tipomembresia" name="tipomembresia" required onchange="actualizarFechaYMonto()">
                    <option value="">Seleccione un tipo</option>
                    <option value="mensual">Mensual</option>
                    <option value="trimestral">Trimestral (3 meses)</option>
                    <option value="semestral">Semestral (6 meses)</option>
                    <option value="anual">Anual</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fechavencimiento" class="form-label">Fecha de Vencimiento *</label>
                <input type="date" class="form-control" id="fechavencimiento" name="fechavencimiento" required>
                <div class="form-text">Se calcula automáticamente según el tipo de membresía.</div>
            </div>
            <div class="col-md-6">
                <label for="monto" class="form-label">Monto (₡) *</label>
                <input type="number" class="form-control" id="monto" name="monto" min="0" step="1000" required>
                <div class="form-text">Monto sugerido según el tipo de membresía seleccionado.</div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button type="reset" class="btn btn-outline-secondary me-md-2">Limpiar Formulario</button>
            <button type="submit" class="btn btn-primary">Guardar Inscripción</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
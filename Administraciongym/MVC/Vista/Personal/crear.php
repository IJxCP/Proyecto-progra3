<?php

echo "BASE_PATH definido: " . (defined('BASE_PATH') ? 'Sí' : 'No') . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . __FILE__ . "<br>";


$rutaUsuarioControlador = $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
echo "Ruta a probar: " . $rutaUsuarioControlador . "<br>";
echo "El archivo existe: " . (file_exists($rutaUsuarioControlador) ? 'Sí' : 'No') . "<br>";


if (file_exists($rutaUsuarioControlador)) {
    require_once $rutaUsuarioControlador;
    UsuarioControlador::verificarAutenticacion();
} else {
    echo "No se pudo encontrar el archivo UsuarioControlador.php";

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Registro de Personal</title>
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
        <h2>Registro de Nuevo Personal</h2>
        <a href="index.php?controlador=gestionpersonal&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <form action="index.php?controlador=gestionpersonal&accion=guardar" method="post">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre_completo" class="form-label">Nombre Completo *</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="puesto" class="form-label">Puesto de Trabajo *</label>
                <select class="form-control" id="puesto" name="puesto" required>
                    <option value="">Seleccione un puesto</option>
                    <option value="Administrativo">Administrativo</option>
                    <option value="Entrenador">Entrenador</option>
                    <option value="Limpieza/Mantenimiento">Limpieza/Mantenimiento</option>
                    <option value="Recepcionista">Recepcionista</option>
                    <option value="Instructor de Clases">Instructor de Clases</option>
                    <option value="Nutricionista">Nutricionista</option>
                    <option value="Fisioterapeuta">Fisioterapeuta</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso *</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="estado" class="form-label">Estado *</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="Activo" selected>Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo Electrónico *</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono *</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" required>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button type="reset" class="btn btn-outline-secondary me-md-2">Limpiar Formulario</button>
            <button type="submit" class="btn btn-primary">Guardar Personal</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
UsuarioControlador::verificarAutenticacion();


if (!isset($mantenimiento) || !$mantenimiento) {
    header("Location: index.php?controlador=mantenimiento&accion=index");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Editar Mantenimiento</title>
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
        <h2>Editar Mantenimiento</h2>
        <a href="index.php?controlador=mantenimiento&accion=ver&id=<?php echo $mantenimiento->getId(); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a detalles
        </a>
    </div>

    <form action="index.php?controlador=mantenimiento&accion=actualizar" method="post">
        <input type="hidden" name="id" value="<?php echo $mantenimiento->getId(); ?>">

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción *</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?php echo htmlspecialchars($mantenimiento->getDescripcion()); ?></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha" class="form-label">Fecha *</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $mantenimiento->getFecha(); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="responsable" class="form-label">Responsable *</label>
                <input type="text" class="form-control" id="responsable" name="responsable" value="<?php echo htmlspecialchars($mantenimiento->getResponsable()); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado *</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="Pendiente" <?php echo ($mantenimiento->getEstado() == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                <option value="En proceso" <?php echo ($mantenimiento->getEstado() == 'En proceso') ? 'selected' : ''; ?>>En proceso</option>
                <option value="Completado" <?php echo ($mantenimiento->getEstado() == 'Completado') ? 'selected' : ''; ?>>Completado</option>
            </select>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="index.php?controlador=mantenimiento&accion=ver&id=<?php echo $mantenimiento->getId(); ?>" class="btn btn-outline-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
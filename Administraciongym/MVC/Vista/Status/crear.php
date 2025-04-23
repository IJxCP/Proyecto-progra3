<?php
// Verificar autenticación
require_once $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
UsuarioControlador::verificarAutenticacion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Nuevo Estado</title>
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

        .estado-preview {
            padding: 15px;
            border-radius: 8px;
            color: white;
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
        }
    </style>
    <script>
        function updatePreview() {
            const nombre = document.getElementById('nombre').value;
            const preview = document.getElementById('estado-preview');

            // Reset preview
            preview.className = 'estado-preview';
            preview.innerHTML = nombre || 'Vista previa del estado';

            // Apply appropriate class based on name
            const lowerNombre = nombre.toLowerCase();
            if (lowerNombre === 'activo') {
                preview.classList.add('bg-success');
                preview.innerHTML = '<i class="fas fa-check-circle"></i> ' + nombre;
            } else if (lowerNombre === 'inactivo') {
                preview.classList.add('bg-danger');
                preview.innerHTML = '<i class="fas fa-times-circle"></i> ' + nombre;
            } else if (lowerNombre === 'suspendido') {
                preview.classList.add('bg-warning');
                preview.classList.add('text-dark');
                preview.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + nombre;
            } else if (lowerNombre === 'dadodebaja') {
                preview.classList.add('bg-secondary');
                preview.innerHTML = '<i class="fas fa-user-slash"></i> ' + nombre;
            } else {
                preview.classList.add('bg-info');
                preview.innerHTML = '<i class="fas fa-info-circle"></i> ' + nombre;
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
        <h2>Crear Nuevo Estado</h2>
        <a href="index.php?controlador=status&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <form action="index.php?controlador=status&accion=guardar" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Estado *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Activo, Inactivo, etc." oninput="updatePreview()">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción *</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required placeholder="Describa el significado de este estado..."></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Vista previa</label>
            <div id="estado-preview" class="estado-preview bg-info">
                <i class="fas fa-info-circle"></i> Vista previa del estado
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button type="reset" class="btn btn-outline-secondary me-md-2" onclick="updatePreview()">Limpiar Formulario</button>
            <button type="submit" class="btn btn-primary">Guardar Estado</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
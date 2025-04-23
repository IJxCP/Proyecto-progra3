<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
UsuarioControlador::verificarAutenticacion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Detalles de Inscripción</title>
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

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
        }

        h2, h3 {
            color: #003366;
        }

        .badge-activo {
            background-color: #28a745;
        }

        .badge-inactivo {
            background-color: #dc3545;
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
        <h2>Detalles de Inscripción</h2>
        <a href="index.php?controlador=inscripcion&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <?php if (isset($inscripcionCompleta)): ?>
    <?php
    $inscripcion = $inscripcionCompleta['inscripcion'];
    $gestionDatos = $inscripcionCompleta['gestionDatos'];
    $cliente = $gestionDatos['cliente']['cliente'];
    $datosPersonales = $gestionDatos['cliente']['datosPersonales'];
    $status = $gestionDatos['status'];

    $fechaActual = new DateTime();
    $fechaVencimiento = new DateTime($inscripcion->getFechaVencimiento());
    $vigente = $fechaActual <= $fechaVencimiento;
    $diasRestantes = 0;
    if ($vigente) {
        $diasRestantes = $fechaActual->diff($fechaVencimiento)->days;
    } else {
        $diasRestantes = -$fechaActual->diff($fechaVencimiento)->days;
    }
    ?>



</div>
<?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

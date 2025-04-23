<?php

session_start();
$nombre_usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuario';
?>
<!DOCTYPE html>
<!-- El resto del HTML se mantiene igual -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Menú Principal</title>
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
            padding-bottom: 30px;
        }

        .menu-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
            transition: transform 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #003366;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
            text-align: center;
        }

        .card-text {
            color: #666;
            text-align: center;
            font-size: 0.9rem;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 30px;
            border-top: 1px solid #e9ecef;
        }

        .user-welcome {
            color: white;
            margin-right: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../assets/logo.png" alt="Logo" width="30" height="30">
            VitalFit
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php?controlador=usuario&accion=cerrarSesion">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4 text-center">Panel de Administración</h2>

    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=cliente&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-users card-icon"></i>
                    <h3 class="card-title">Gestión de Clientes</h3>
                    <p class="card-text">Registra, consulta y actualiza la información de los clientes</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=inscripcion&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-id-card card-icon"></i>
                    <h3 class="card-title">Inscripciones</h3>
                    <p class="card-text">Gestiona las inscripciones de los clientes</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=cuota&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-dollar-sign card-icon"></i>
                    <h3 class="card-title">Gestión de Cuotas</h3>
                    <p class="card-text">Registra y consulta los pagos de membresías</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=gestionpersonal&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-user-tie card-icon"></i>
                    <h3 class="card-title">Personal</h3>
                    <p class="card-text">Administra la información del personal del gimnasio</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=analisisdatos&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-chart-bar card-icon"></i>
                    <h3 class="card-title">Análisis de Datos</h3>
                    <p class="card-text">Visualiza estadísticas y reportes del gimnasio</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=inventario&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-boxes card-icon"></i>
                    <h3 class="card-title">Inventario</h3>
                    <p class="card-text">Gestiona el inventario de equipos y suministros</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=mantenimiento&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-tools card-icon"></i>
                    <h3 class="card-title">Mantenimiento</h3>
                    <p class="card-text">Programa y registra el mantenimiento de equipos</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=status&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-toggle-on card-icon"></i>
                    <h3 class="card-title">Estado de Clientes</h3>
                    <p class="card-text">Gestiona el estado y status de los clientes</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="../../index.php?controlador=usuario&accion=index" class="text-decoration-none">
                <div class="menu-card">
                    <i class="fas fa-user-cog card-icon"></i>
                    <h3 class="card-title">Usuarios</h3>
                    <p class="card-text">Administra los usuarios del sistema</p>
                </div>
            </a>
        </div>
    </div>

    <footer class="footer mt-5 text-center">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> VitalFit - Sistema de Administración de Gimnasio</p>
            <p class="text-muted">Versión 1.0.0</p>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
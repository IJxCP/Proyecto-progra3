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
    <title>VitalFit - Detalles de Mantenimiento</title>
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

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white !important;
            }

            .container {
                box-shadow: none !important;
                margin-top: 0 !important;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark no-print">
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
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h2>Detalles del Mantenimiento</h2>
        <a href="index.php?controlador=mantenimiento&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>


    <div class="d-none d-print-block text-center mb-4">
        <h2>VitalFit - Registro de Mantenimiento</h2>
        <p>Fecha de impresión: <?php echo date('d/m/Y'); ?></p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-tools"></i> Información de Mantenimiento</span>
                <?php
                $estado = $mantenimiento->getEstado();
                $badgeClass = '';

                if ($estado == 'Completado') {
                    $badgeClass = 'bg-success';
                } elseif ($estado == 'Pendiente') {
                    $badgeClass = 'bg-warning text-dark';
                } elseif ($estado == 'En proceso') {
                    $badgeClass = 'bg-info';
                }
                ?>
                <span class="badge <?php echo $badgeClass; ?>">
                    <?php echo $estado; ?>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><span class="detail-label">ID:</span> <?php echo $mantenimiento->getId(); ?></p>
                    <p><span class="detail-label">Fecha:</span> <?php echo date('d/m/Y', strtotime($mantenimiento->getFecha())); ?></p>
                    <p><span class="detail-label">Responsable:</span> <?php echo $mantenimiento->getResponsable(); ?></p>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="mb-2">Descripción</h5>
                <div class="p-3 bg-light rounded">
                    <?php echo nl2br(htmlspecialchars($mantenimiento->getDescripcion())); ?>
                </div>
            </div>

            <?php if ($estado == 'Completado'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Este mantenimiento ha sido completado satisfactoriamente.
                </div>
            <?php elseif ($estado == 'En proceso'): ?>
                <div class="alert alert-info">
                    <i class="fas fa-spinner fa-spin"></i> Este mantenimiento se encuentra actualmente en proceso.
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Este mantenimiento está pendiente de realizar.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-between no-print">
        <div>
            <a href="javascript:window.print();" class="btn btn-outline-secondary">
                <i class="fas fa-print"></i> Imprimir
            </a>
        </div>
        <div>
            <?php if ($estado != 'Completado'): ?>
                <a href="index.php?controlador=mantenimiento&accion=marcarCompletado&id=<?php echo $mantenimiento->getId(); ?>" class="btn btn-success me-2">
                    <i class="fas fa-check-circle"></i> Marcar como Completado
                </a>
            <?php endif; ?>
            <a href="index.php?controlador=mantenimiento&accion=editar&id=<?php echo $mantenimiento->getId(); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
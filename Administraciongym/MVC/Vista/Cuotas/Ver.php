<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
UsuarioControlador::verificarAutenticacion();



if (!isset($cuota) || !$cuota) {
    header("Location: index.php?controlador=cuota&accion=index");
    exit();
}


require_once 'MVC/Modelo/InscripcionM.php';
$inscripcionModelo = new InscripcionM();
$inscripcionCompleta = $inscripcionModelo->BuscarInscripcionCompleta($cuota->getIdInscripcion());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Detalles de Pago</title>
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

        .badge-pagado {
            background-color: #28a745;
        }

        .badge-pendiente {
            background-color: #ffc107;
        }

        .badge-atrasado {
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
        <h2>Detalles del Pago</h2>
        <a href="index.php?controlador=cuota&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-dollar-sign"></i> Información del Pago
                </div>
                <div class="card-body">
                    <p><span class="detail-label">ID de Pago:</span> <?php echo $cuota->getId(); ?></p>
                    <p><span class="detail-label">ID de Inscripción:</span> <?php echo $cuota->getIdInscripcion(); ?></p>
                    <p><span class="detail-label">Fecha de Pago:</span> <?php echo date('d/m/Y', strtotime($cuota->getFechaPago())); ?></p>
                    <p><span class="detail-label">Monto:</span> ₡<?php echo number_format($cuota->getMonto(), 2); ?></p>
                    <p><span class="detail-label">Método de Pago:</span> <?php echo ucfirst($cuota->getMetodoPago()); ?></p>
                    <?php if (!empty($cuota->getComprobante())): ?>
                        <p><span class="detail-label">Número de Comprobante:</span> <?php echo $cuota->getComprobante(); ?></p>
                    <?php endif; ?>
                    <p><span class="detail-label">Estado:</span>
                        <?php if ($cuota->getEstado() == 'pagado'): ?>
                            <span class="badge bg-success">Pagado</span>
                        <?php elseif ($cuota->getEstado() == 'pendiente'): ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Atrasado</span>
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($cuota->getObservaciones())): ?>
                        <p><span class="detail-label">Observaciones:</span> <?php echo $cuota->getObservaciones(); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($cuota->getEstado() != 'pagado'): ?>
                <div class="d-grid gap-2 mt-3">
                    <a href="index.php?controlador=cuota&accion=marcarPagado&id=<?php echo $cuota->getId(); ?>" class="btn btn-success">
                        <i class="fas fa-check-circle"></i> Marcar como Pagado
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <?php if (isset($inscripcionCompleta) && $inscripcionCompleta): ?>
                <?php
                $inscripcion = $inscripcionCompleta['inscripcion'];
                $gestionDatos = $inscripcionCompleta['gestionDatos'];
                $cliente = $gestionDatos['cliente']['cliente'];
                $datosPersonales = $gestionDatos['cliente']['datosPersonales'];
                ?>
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user"></i> Información del Cliente
                    </div>
                    <div class="card-body">
                        <p><span class="detail-label">Nombre:</span> <?php echo $datosPersonales->getNombre() . ' ' . $datosPersonales->getApellido1() . ' ' . $datosPersonales->getApellido2(); ?></p>
                        <p><span class="detail-label">Teléfono:</span> <?php echo $datosPersonales->getTelefono(); ?></p>
                        <p><span class="detail-label">Correo:</span> <?php echo $datosPersonales->getCorreo(); ?></p>
                        <a href="index.php?controlador=cliente&accion=ver&id=<?php echo $cliente->getId(); ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Ver perfil completo
                        </a>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <i class="fas fa-id-card"></i> Detalles de la Inscripción
                    </div>
                    <div class="card-body">
                        <p><span class="detail-label">Tipo Membresía:</span> <?php echo ucfirst($inscripcion->getTipoMembresia()); ?></p>
                        <p><span class="detail-label">Fecha Inscripción:</span> <?php echo date('d/m/Y', strtotime($inscripcion->getFechaInscripcion())); ?></p>
                        <p><span class="detail-label">Fecha Vencimiento:</span> <?php echo date('d/m/Y', strtotime($inscripcion->getFechaVencimiento())); ?></p>
                        <p><span class="detail-label">Monto:</span> ₡<?php echo number_format($inscripcion->getMonto(), 2); ?></p>
                        <?php

                        $fechaActual = new DateTime();
                        $fechaVencimiento = new DateTime($inscripcion->getFechaVencimiento());
                        $vigente = $fechaActual <= $fechaVencimiento;
                        $diasRestantes = $vigente ? $fechaActual->diff($fechaVencimiento)->days : -$fechaActual->diff($fechaVencimiento)->days;
                        ?>
                        <p><span class="detail-label">Estado:</span>
                            <?php if ($vigente): ?>
                                <span class="badge bg-success">Vigente (<?php echo $diasRestantes; ?> días restantes)</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Vencido (hace <?php echo abs($diasRestantes); ?> días)</span>
                            <?php endif; ?>
                        </p>
                        <a href="index.php?controlador=inscripcion&accion=ver&id=<?php echo $inscripcion->getId(); ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Ver detalles de inscripción
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-exclamation-triangle"></i> Información no disponible
                    </div>
                    <div class="card-body">
                        <p>No se pudo cargar la información de la inscripción o del cliente.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-between">
        <a href="javascript:window.print();" class="btn btn-outline-secondary">
            <i class="fas fa-print"></i> Imprimir Comprobante
        </a>
        <div>
            <a href="index.php?controlador=cuota&accion=index" class="btn btn-primary me-2">
                <i class="fas fa-list"></i> Ver Todos los Pagos
            </a>
            <?php if ($cuota->getEstado() != 'pagado'): ?>
                <a href="index.php?controlador=cuota&accion=editar&id=<?php echo $cuota->getId(); ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar Pago
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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

    // Determinar si la inscripción está vigente
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

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user"></i> Información del Cliente
                </div>
                <div class="card-body">
                    <p><span class="detail-label">Nombre:</span> <?php echo $datosPersonales->getNombre() . ' ' . $datosPersonales->getApellido1() . ' ' . $datosPersonales->getApellido2(); ?></p>
                    <p><span class="detail-label">Teléfono:</span> <?php echo $datosPersonales->getTelefono(); ?></p>
                    <p><span class="detail-label">Correo:</span> <?php echo $datosPersonales->getCorreo(); ?></p>
                    <p><span class="detail-label">Status:</span>
                        <?php if ($status->getNombre() == 'Activo'): ?>
                            <span class="badge bg-success"><?php echo $status->getNombre(); ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger"><?php echo $status->getNombre(); ?></span>
                        <?php endif; ?>
                    </p>
                    <a href="index.php?controlador=cliente&accion=ver&id=<?php echo $cliente->getId(); ?>" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Ver perfil completo
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-id-card"></i> Detalles de la Inscripción
                </div>
                <div class="card-body">
                    <p><span class="detail-label">ID Inscripción:</span> <?php echo $inscripcion->getId(); ?></p>
                    <p><span class="detail-label">Tipo Membresía:</span> <?php echo ucfirst($inscripcion->getTipoMembresia()); ?></p>
                    <p><span class="detail-label">Fecha Inscripción:</span> <?php echo date('d/m/Y', strtotime($inscripcion->getFechaInscripcion())); ?></p>
                    <p><span class="detail-label">Fecha Vencimiento:</span> <?php echo date('d/m/Y', strtotime($inscripcion->getFechaVencimiento())); ?></p>
                    <p><span class="detail-label">Monto:</span> ₡<?php echo number_format($inscripcion->getMonto(), 2); ?></p>
                    <p><span class="detail-label">Estado:</span>
                        <?php if ($vigente): ?>
                            <span class="badge bg-success">Vigente (<?php echo $diasRestantes; ?> días restantes)</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Vencido (hace <?php echo $diasRestantes; ?> días)</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-dollar-sign"></i> Historial de Pagos
                </div>
                <div class="card-body">
                    <?php
                    // Aquí se muestra el historial de pagos asociados a esta inscripción
                    require_once 'MVC/Modelo/GestionCuotasM.php';
                    $cuotasModelo = new GestionCuotasM();
                    $historialPagos = $cuotasModelo->BuscarPorInscripcion($inscripcion->getId());

                    if ($historialPagos && count($historialPagos) > 0):
                        ?>
                        <h5 class="mb-3">Historial de Pagos</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Método</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($historialPagos as $pago): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($pago->getFechaPago())); ?></td>
                                        <td>₡<?php echo number_format($pago->getMonto(), 2); ?></td>
                                        <td><?php echo ucfirst($pago->getMetodoPago()); ?></td>
                                        <td>
                                            <?php if ($pago->getEstado() === 'pagado'): ?>
                                                <span class="badge bg-success">Pagado</span>
                                            <?php elseif ($pago->getEstado() === 'pendiente'): ?>
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Atrasado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="index.php?controlador=cuota&accion=ver&id=<?php echo $pago->getId(); ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No hay pagos registrados para esta inscripción.
                        </div>
                    <?php endif; ?>

                    <!-- Botones de acción -->
                    <div class="mt-3">
                        <a href="index.php?controlador=cuota&accion=crear&idinscripcion=<?php echo $inscripcion->getId(); ?>" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Registrar nuevo pago
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-between">
    <div>
        <a href="index.php?controlador=cliente&accion=ver&id=<?php echo $cliente->getId(); ?>" class="btn btn-info">
            <i class="fas fa-user"></i> Ver perfil del cliente
        </a>
    </div>
    <div>
        <?php if (!$vigente): ?>
            <a href="index.php?controlador=inscripcion&accion=renovar&id=<?php echo $inscripcion->getId(); ?>" class="btn btn-warning me-2">
                <i class="fas fa-sync-alt"></i> Renovar membresía
            </a>
        <?php endif; ?>
        <a href="index.php?controlador=inscripcion&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
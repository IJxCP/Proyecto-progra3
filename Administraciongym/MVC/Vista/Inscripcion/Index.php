<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Gestión de Inscripciones</title>
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

        .btn-action {
            margin-right: 5px;
        }

        h2 {
            color: #003366;
        }

        .search-container {
            margin-bottom: 20px;
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
    <!-- Mensajes de alerta -->
    <?php if (isset($_SESSION['mensaje']) && isset($_SESSION['tipo_mensaje'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php

        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
        ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Inscripciones</h2>
        <a href="index.php?controlador=inscripcion&accion=crear" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nueva Inscripción
        </a>
    </div>

    <div class="row">
        <div class="col-md-6 search-container">
            <form action="index.php" method="get" class="d-flex">
                <input type="hidden" name="controlador" value="inscripcion">
                <input type="hidden" name="accion" value="buscar">
                <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar por nombre de cliente">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-6 filter-container text-end">
            <div class="btn-group" role="group">
                <a href="index.php?controlador=inscripcion&accion=index" class="btn btn-outline-secondary active">
                    <i class="fas fa-list"></i> Todos
                </a>
                <a href="index.php?controlador=inscripcion&accion=filtrarPorVencimiento&dias=30" class="btn btn-outline-warning">
                    <i class="fas fa-exclamation-triangle"></i> Por vencer (30 días)
                </a>
                <a href="index.php?controlador=inscripcion&accion=filtrarPorEstado&estado=vencido" class="btn btn-outline-danger">
                    <i class="fas fa-times-circle"></i> Vencidos
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Tipo Membresía</th>
                <th>Fecha Inscripción</th>
                <th>Fecha Vencimiento</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($inscripciones) && is_array($inscripciones) && count($inscripciones) > 0): ?>
                <?php foreach ($inscripciones as $inscripcion): ?>
                    <?php

                    $fechaActual = new DateTime();
                    $fechaVencimiento = new DateTime($inscripcion->getFechaVencimiento());
                    $vigente = $fechaActual <= $fechaVencimiento;
                    $diasRestantes = $vigente ? $fechaActual->diff($fechaVencimiento)->days : 0;
                    ?>
                    <tr>
                        <td><?php echo $inscripcion->getId(); ?></td>
                        <td><?php echo $inscripcion->getNombreCliente(); ?></td>
                        <td><?php echo $inscripcion->getTipoMembresia(); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($inscripcion->getFechaInscripcion())); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($inscripcion->getFechaVencimiento())); ?></td>
                        <td>₡<?php echo number_format($inscripcion->getMonto(), 2); ?></td>
                        <td>
                            <?php if ($vigente): ?>
                                <span class="badge bg-success">Vigente (<?php echo $diasRestantes; ?> días)</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Vencido</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?controlador=inscripcion&accion=ver&id=<?php echo $inscripcion->getId(); ?>" class="btn btn-sm btn-info btn-action" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="index.php?controlador=cuota&accion=crear&idinscripcion=<?php echo $inscripcion->getId(); ?>" class="btn btn-sm btn-success btn-action" title="Registrar pago">
                                <i class="fas fa-dollar-sign"></i>
                            </a>
                            <?php if (!$vigente): ?>
                                <a href="index.php?controlador=inscripcion&accion=renovar&id=<?php echo $inscripcion->getId(); ?>" class="btn btn-sm btn-warning btn-action" title="Renovar membresía">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            <?php endif; ?>
                            <a href="javascript:void(0);" onclick="confirmarEliminar(<?php echo $inscripcion->getId(); ?>)" class="btn btn-sm btn-danger btn-action" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No hay inscripciones registradas</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="eliminarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea eliminar esta inscripción? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmarEliminar(id) {
        document.getElementById('btn-eliminar').href = 'index.php?controlador=inscripcion&accion=eliminar&id=' + id;
        var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
        modal.show();
    }
</script>
</body>
</html>
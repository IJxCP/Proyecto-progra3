<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Control de Mantenimiento</title>
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

        .filter-container {
            margin-bottom: 20px;
        }

        .badge-completado {
            background-color: #28a745;
        }

        .badge-pendiente {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-en-proceso {
            background-color: #17a2b8;
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
        // Limpiar las variables de sesión después de mostrar el mensaje
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
        ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Control de Mantenimiento</h2>
        <a href="index.php?controlador=mantenimiento&accion=crear" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Mantenimiento
        </a>
    </div>

    <div class="row">
        <div class="col-md-6 search-container">
            <form action="index.php" method="get" class="d-flex">
                <input type="hidden" name="controlador" value="mantenimiento">
                <input type="hidden" name="accion" value="buscar">
                <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar por descripción o responsable">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-6 filter-container text-end">
            <div class="btn-group" role="group">
                <a href="index.php?controlador=mantenimiento&accion=index" class="btn btn-outline-secondary active">
                    <i class="fas fa-list"></i> Todos
                </a>
                <a href="index.php?controlador=mantenimiento&accion=filtrarPorEstado&estado=Pendiente" class="btn btn-outline-warning">
                    <i class="fas fa-clock"></i> Pendientes
                </a>
                <a href="index.php?controlador=mantenimiento&accion=filtrarPorEstado&estado=En proceso" class="btn btn-outline-info">
                    <i class="fas fa-spinner"></i> En Proceso
                </a>
                <a href="index.php?controlador=mantenimiento&accion=filtrarPorEstado&estado=Completado" class="btn btn-outline-success">
                    <i class="fas fa-check-circle"></i> Completados
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($mantenimientos) && is_array($mantenimientos) && count($mantenimientos) > 0): ?>
                <?php foreach ($mantenimientos as $mantenimiento): ?>
                    <tr>
                        <td><?php echo $mantenimiento->getId(); ?></td>
                        <td>
                            <?php
                            // Mostrar un resumen de la descripción (primeros 50 caracteres)
                            echo strlen($mantenimiento->getDescripcion()) > 50 ?
                                substr($mantenimiento->getDescripcion(), 0, 50) . '...' :
                                $mantenimiento->getDescripcion();
                            ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($mantenimiento->getFecha())); ?></td>
                        <td><?php echo $mantenimiento->getResponsable(); ?></td>
                        <td>
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
                        </td>
                        <td>
                            <a href="index.php?controlador=mantenimiento&accion=ver&id=<?php echo $mantenimiento->getId(); ?>" class="btn btn-sm btn-info btn-action" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="index.php?controlador=mantenimiento&accion=editar&id=<?php echo $mantenimiento->getId(); ?>" class="btn btn-sm btn-warning btn-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" onclick="confirmarEliminar(<?php echo $mantenimiento->getId(); ?>)" class="btn btn-sm btn-danger btn-action" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay mantenimientos registrados</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea eliminar este registro de mantenimiento? Esta acción no se puede deshacer.
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
        document.getElementById('btn-eliminar').href = 'index.php?controlador=mantenimiento&accion=eliminar&id=' + id;
        var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
        modal.show();
    }
</script>
</body>
</html>
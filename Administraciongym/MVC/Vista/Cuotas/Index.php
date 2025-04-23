<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Gestión de Cuotas</title>
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
        <h2>Gestión de Cuotas</h2>
        <a href="index.php?controlador=cuota&accion=crear" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Registrar Nuevo Pago
        </a>
    </div>

    <div class="row">
        <div class="col-md-6 search-container">
            <form action="index.php" method="get" class="d-flex">
                <input type="hidden" name="controlador" value="cuota">
                <input type="hidden" name="accion" value="buscar">
                <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar por cliente">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-6 filter-container text-end">
            <div class="btn-group" role="group">
                <a href="index.php?controlador=cuota&accion=index" class="btn btn-outline-secondary active">
                    <i class="fas fa-list"></i> Todos
                </a>
                <a href="index.php?controlador=cuota&accion=filtrarPorEstado&estado=pagado" class="btn btn-outline-success">
                    <i class="fas fa-check-circle"></i> Pagados
                </a>
                <a href="index.php?controlador=cuota&accion=filtrarPorEstado&estado=pendiente" class="btn btn-outline-warning">
                    <i class="fas fa-clock"></i> Pendientes
                </a>
                <a href="index.php?controlador=cuota&accion=filtrarPorEstado&estado=atrasado" class="btn btn-outline-danger">
                    <i class="fas fa-exclamation-circle"></i> Atrasados
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
                <th>Fecha de Pago</th>
                <th>Monto</th>
                <th>Método de Pago</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($cuotas) && is_array($cuotas) && count($cuotas) > 0): ?>
                <?php foreach ($cuotas as $cuota): ?>
                    <tr>
                        <td><?php echo $cuota->getId(); ?></td>
                        <td>
                            <?php
                            // Aquí podríamos mostrar el nombre del cliente si estuviera disponible
                            echo "Cliente #" . $cuota->getIdInscripcion();
                            ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($cuota->getFechaPago())); ?></td>
                        <td>₡<?php echo number_format($cuota->getMonto(), 2); ?></td>
                        <td><?php echo ucfirst($cuota->getMetodoPago()); ?></td>
                        <td>
                            <?php if ($cuota->getEstado() == 'pagado'): ?>
                                <span class="badge bg-success">Pagado</span>
                            <?php elseif ($cuota->getEstado() == 'pendiente'): ?>
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Atrasado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?controlador=cuota&accion=ver&id=<?php echo $cuota->getId(); ?>" class="btn btn-sm btn-info btn-action" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($cuota->getEstado() != 'pagado'): ?>
                                <a href="index.php?controlador=cuota&accion=marcarPagado&id=<?php echo $cuota->getId(); ?>" class="btn btn-sm btn-success btn-action" title="Marcar como pagado">
                                    <i class="fas fa-check"></i>
                                </a>
                            <?php endif; ?>
                            <a href="javascript:void(0);" onclick="confirmarEliminar(<?php echo $cuota->getId(); ?>)" class="btn btn-sm btn-danger btn-action" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No hay cuotas registradas</td>
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
                ¿Está seguro que desea eliminar este registro de pago? Esta acción no se puede deshacer.
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
        document.getElementById('btn-eliminar').href = 'index.php?controlador=cuota&accion=eliminar&id=' + id;
        var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
        modal.show();
    }
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Estados de Cliente</title>
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

        .status-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .status-card:hover {
            transform: translateY(-5px);
        }

        .status-card-header {
            padding: 15px;
            border-radius: 10px 10px 0 0;
            color: white;
            font-weight: bold;
        }

        .status-card-body {
            padding: 15px;
        }

        .status-activo {
            background-color: #28a745;
        }

        .status-inactivo {
            background-color: #dc3545;
        }

        .status-suspendido {
            background-color: #ffc107;
            color: #212529;
        }

        .status-dadodebaja {
            background-color: #6c757d;
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
        <h2>Estados de Cliente</h2>
        <a href="index.php?controlador=status&accion=crear" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Estado
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 search-container">
            <form action="index.php" method="get" class="d-flex">
                <input type="hidden" name="controlador" value="status">
                <input type="hidden" name="accion" value="buscar">
                <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar por nombre">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Tarjetas de estado predefinidas -->
    <div class="row">
        <?php if (isset($status) && is_array($status) && count($status) > 0): ?>
            <?php foreach ($status as $item): ?>
                <?php
                $statusClass = 'status-dadodebaja';
                $icon = 'question-circle';

                switch(strtolower($item->getNombre())) {
                    case 'activo':
                        $statusClass = 'status-activo';
                        $icon = 'check-circle';
                        break;
                    case 'inactivo':
                        $statusClass = 'status-inactivo';
                        $icon = 'times-circle';
                        break;
                    case 'suspendido':
                        $statusClass = 'status-suspendido';
                        $icon = 'exclamation-circle';
                        break;
                    case 'dadodebaja':
                        $statusClass = 'status-dadodebaja';
                        $icon = 'user-slash';
                        break;
                }
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card status-card">
                        <div class="status-card-header <?php echo $statusClass; ?>">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-<?php echo $icon; ?>"></i> <?php echo $item->getNombre(); ?></span>
                                <div>
                                    <a href="index.php?controlador=status&accion=editar&id=<?php echo $item->getId(); ?>" class="btn btn-sm btn-light btn-action" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if (!in_array(strtolower($item->getNombre()), ['activo', 'inactivo', 'suspendido', 'dadodebaja'])): ?>
                                        <a href="javascript:void(0);" onclick="confirmarEliminar(<?php echo $item->getId(); ?>)" class="btn btn-sm btn-light btn-action" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="status-card-body">
                            <p><?php echo htmlspecialchars($item->getDescripcion()); ?></p>
                            <a href="index.php?controlador=gestiondatos&accion=filtrarPorStatus&idstatus=<?php echo $item->getId(); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-users"></i> Ver clientes con este estado
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No hay estados registrados en el sistema.
                </div>
            </div>
        <?php endif; ?>
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
                ¿Está seguro que desea eliminar este estado? Esta acción no se puede deshacer.<br>
                <strong>Nota:</strong> Solo se pueden eliminar estados que no estén asignados a ningún cliente.
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
        document.getElementById('btn-eliminar').href = 'index.php?controlador=status&accion=eliminar&id=' + id;
        var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
        modal.show();
    }
</script>
</body>
</html>
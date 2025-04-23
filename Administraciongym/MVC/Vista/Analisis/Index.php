<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Análisis de Datos</title>
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

        .card-stat {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .tipo-analisis-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
        }

        .progress-circle {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }

        .progress-circle__value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            font-weight: bold;
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
        <h2>Análisis de Datos</h2>
        <a href="index.php?controlador=analisisdatos&accion=crear" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Análisis
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 search-container">
            <form action="index.php" method="get" class="d-flex">
                <input type="hidden" name="controlador" value="analisisdatos">
                <input type="hidden" name="accion" value="buscar">
                <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar por cliente o tipo de análisis">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-6 filter-container text-end">
            <div class="btn-group" role="group">
                <a href="index.php?controlador=analisisdatos&accion=index" class="btn btn-outline-secondary active">
                    <i class="fas fa-list"></i> Todos
                </a>
                <a href="index.php?controlador=analisisdatos&accion=filtrarPorTipo&tipo=Progreso físico" class="btn btn-outline-info">
                    <i class="fas fa-running"></i> Progreso físico
                </a>
                <a href="index.php?controlador=analisisdatos&accion=filtrarPorTipo&tipo=Evaluación nutricional" class="btn btn-outline-success">
                    <i class="fas fa-apple-alt"></i> Evaluación nutricional
                </a>
                <a href="index.php?controlador=analisisdatos&accion=filtrarPorTipo&tipo=Test de capacidad física" class="btn btn-outline-danger">
                    <i class="fas fa-heartbeat"></i> Test de capacidad
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
                <th>Fecha</th>
                <th>Tipo de Análisis</th>
                <th>Resultado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($analisis) && is_array($analisis) && count($analisis) > 0): ?>
                <?php foreach ($analisis as $item): ?>
                    <tr>
                        <td><?php echo $item->getId(); ?></td>
                        <td><?php echo $item->getNombreCliente(); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($item->getFecha())); ?></td>
                        <td>
                            <?php
                            $tipo = $item->getTipoAnalisis();
                            $badgeClass = 'bg-secondary';

                            if ($tipo == 'Progreso físico') {
                                $badgeClass = 'bg-info';
                            } elseif ($tipo == 'Evaluación nutricional') {
                                $badgeClass = 'bg-success';
                            } elseif ($tipo == 'Test de capacidad física') {
                                $badgeClass = 'bg-danger';
                            } elseif ($tipo == 'Evaluación médica') {
                                $badgeClass = 'bg-warning';
                            }
                            ?>
                            <span class="badge <?php echo $badgeClass; ?> tipo-analisis-badge">
                                <?php echo $tipo; ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            // Mostrar un resumen del resultado (primeros 30 caracteres)
                            echo strlen($item->getResultado()) > 30 ?
                                substr($item->getResultado(), 0, 30) . '...' :
                                $item->getResultado();
                            ?>
                        </td>
                        <td>
                            <a href="index.php?controlador=analisisdatos&accion=ver&id=<?php echo $item->getId(); ?>" class="btn btn-sm btn-info btn-action" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="index.php?controlador=analisisdatos&accion=editar&id=<?php echo $item->getId(); ?>" class="btn btn-sm btn-warning btn-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" onclick="confirmarEliminar(<?php echo $item->getId(); ?>)" class="btn btn-sm btn-danger btn-action" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay análisis registrados</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Si hay cliente específico seleccionado, mostrar más detalles -->
    <?php if (isset($cliente) && $cliente): ?>
        <div class="mt-4">
            <h3 class="mb-3">Análisis de <?php echo $cliente->getNombreCompleto(); ?></h3>

            <!-- Aquí podría ir un gráfico o resumen de los análisis del cliente -->
            <div class="row mt-3">
                <div class="col-12">
                    <a href="index.php?controlador=analisisdatos&accion=crear&idcliente=<?php echo $cliente->getId(); ?>" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Nuevo análisis para este cliente
                    </a>
                    <a href="index.php?controlador=cliente&accion=ver&id=<?php echo $cliente->getId(); ?>" class="btn btn-info">
                        <i class="fas fa-user"></i> Ver perfil del cliente
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
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
                ¿Está seguro que desea eliminar este análisis? Esta acción no se puede deshacer.
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
        document.getElementById('btn-eliminar').href = 'index.php?controlador=analisisdatos&accion=eliminar&id=' + id;
        var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
        modal.show();
    }
</script>
</body>
</html>
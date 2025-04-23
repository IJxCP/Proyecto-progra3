
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Gestión de Clientes</title>
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
        <h2>Listado de Clientes</h2>
        <a href="index.php?controlador=cliente&accion=crear" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Cliente
        </a>
    </div>

    <div class="row search-container">
        <div class="col-md-6">
            <form action="index.php" method="get" class="d-flex">
                <input type="hidden" name="controlador" value="cliente">
                <input type="hidden" name="accion" value="buscar">
                <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar por nombre o apellido">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($clientes) && is_array($clientes) && count($clientes) > 0): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente->getId(); ?></td>
                        <td><?php echo $cliente->getNombreCompleto(); ?></td>
                        <td><?php echo $cliente->getDatosAdicionales('telefono'); ?></td>
                        <td><?php echo $cliente->getDatosAdicionales('correo'); ?></td>
                        <td><?php echo $cliente->getFechaRegistro(); ?></td>
                        <td>
                            <a href="index.php?controlador=cliente&accion=ver&id=<?php echo $cliente->getId(); ?>" class="btn btn-sm btn-info btn-action" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="index.php?controlador=cliente&accion=editar&id=<?php echo $cliente->getId(); ?>" class="btn btn-sm btn-warning btn-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:void(0);" onclick="confirmarEliminar(<?php echo $cliente->getId(); ?>)" class="btn btn-sm btn-danger btn-action" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                            <a href="index.php?controlador=gestiondatos&accion=crear&idcliente=<?php echo $cliente->getId(); ?>" class="btn btn-sm btn-success btn-action" title="Gestionar status">
                                <i class="fas fa-cog"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay clientes registrados</td>
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
                ¿Está seguro que desea eliminar este cliente? Esta acción no se puede deshacer.
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
        document.getElementById('btn-eliminar').href = 'index.php?controlador=cliente&accion=eliminar&id=' + id;
        var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
        modal.show();
    }
</script>
</body>
</html>
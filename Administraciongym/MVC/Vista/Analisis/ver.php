<?php
// Verificar autenticación
require_once $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
UsuarioControlador::verificarAutenticacion();

// Verificar que el análisis y cliente estén cargados correctamente
if (!isset($analisisCompleto) || !$analisisCompleto) {
    header("Location: index.php?controlador=analisisdatos&accion=index");
    exit();
}

// Extraer los datos del análisis y cliente
$analisis = $analisisCompleto['analisis'];
$cliente = $analisisCompleto['cliente'];
$datosPersonales = $cliente['datosPersonales'];
$nombreCliente = $datosPersonales->getNombre() . ' ' . $datosPersonales->getApellido1() . ' ' . $datosPersonales->getApellido2();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Detalles de Análisis</title>
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

        .badge-analisis {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
        }

        .resultado-seccion {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
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
        <h2>Detalles del Análisis</h2>
        <a href="index.php?controlador=analisisdatos&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <!-- Al imprimir, mostrar un encabezado más informativo -->
    <div class="d-none d-print-block text-center mb-4">
        <h2>VitalFit - Informe de Análisis</h2>
        <p>Fecha de impresión: <?php echo date('d/m/Y'); ?></p>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user"></i> Información del Cliente
                </div>
                <div class="card-body">
                    <p><span class="detail-label">Nombre:</span> <?php echo $nombreCliente; ?></p>
                    <p><span class="detail-label">Teléfono:</span> <?php echo $datosPersonales->getTelefono(); ?></p>
                    <p><span class="detail-label">Correo:</span> <?php echo $datosPersonales->getCorreo(); ?></p>

                    <a href="index.php?controlador=cliente&accion=ver&id=<?php echo $cliente['cliente']->getId(); ?>" class="btn btn-sm btn-info no-print">
                        <i class="fas fa-eye"></i> Ver perfil completo
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-line"></i> Información del Análisis
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <p><span class="detail-label">Fecha:</span> <?php echo date('d/m/Y', strtotime($analisis->getFecha())); ?></p>

                        <?php
                        $tipo = $analisis->getTipoAnalisis();
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
                        <span class="badge <?php echo $badgeClass; ?> badge-analisis">
                            <?php echo $tipo; ?>
                        </span>
                    </div>

                    <div class="resultado-seccion">
                        <h5 class="mb-3">Resultados</h5>
                        <p><?php echo nl2br(htmlspecialchars($analisis->getResultado())); ?></p>
                    </div>

                    <?php if (!empty($analisis->getObservaciones())): ?>
                        <div class="resultado-seccion">
                            <h5 class="mb-2">Observaciones</h5>
                            <p><?php echo nl2br(htmlspecialchars($analisis->getObservaciones())); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección para mostrar el histórico de análisis del mismo tipo para este cliente -->
    <div class="row mt-4 no-print">
        <div class="col-12">
            <h3 class="mb-3">Historial de análisis de <?php echo $tipo; ?> del cliente</h3>

            <?php
            // Obtener otros análisis del mismo tipo para este cliente
            require_once 'MVC/Modelo/AnalisisDatosM.php';
            $analisisModelo = new AnalisisDatosM();
            $historico = $analisisModelo->obtenerPorClienteYTipo($analisis->getIdcliente(), $analisis->getTipoAnalisis());

            if (isset($historico) && is_array($historico) && count($historico) > 1): // Más de 1 porque incluye el actual
                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Resultado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($historico as $item):
                            // No mostrar el análisis actual en esta tabla
                            if ($item->getId() == $analisis->getId()) continue;
                            ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($item->getFecha())); ?></td>
                                <td>
                                    <?php
                                    // Mostrar un resumen del resultado
                                    echo strlen($item->getResultado()) > 50 ?
                                        substr($item->getResultado(), 0, 50) . '...' :
                                        $item->getResultado();
                                    ?>
                                </td>
                                <td>
                                    <a href="index.php?controlador=analisisdatos&accion=ver&id=<?php echo $item->getId(); ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No hay análisis previos de este tipo para este cliente.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-between no-print">
        <div>
            <a href="javascript:window.print();" class="btn btn-outline-secondary">
                <i class="fas fa-print"></i> Imprimir Informe
            </a>
        </div>
        <div>
            <a href="index.php?controlador=analisisdatos&accion=crear&idcliente=<?php echo $analisis->getIdcliente(); ?>" class="btn btn-success me-2">
                <i class="fas fa-plus-circle"></i> Nuevo análisis para este cliente
            </a>
            <a href="index.php?controlador=analisisdatos&accion=editar&id=<?php echo $analisis->getId(); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar análisis
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
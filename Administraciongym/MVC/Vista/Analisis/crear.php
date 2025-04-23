<?php

echo "BASE_PATH definido: " . (defined('BASE_PATH') ? 'Sí' : 'No') . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . __FILE__ . "<br>";


$rutaUsuarioControlador = $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
echo "Ruta a probar: " . $rutaUsuarioControlador . "<br>";
echo "El archivo existe: " . (file_exists($rutaUsuarioControlador) ? 'Sí' : 'No') . "<br>";


if (file_exists($rutaUsuarioControlador)) {
    require_once $rutaUsuarioControlador;
    UsuarioControlador::verificarAutenticacion();
} else {
    echo "No se pudo encontrar el archivo UsuarioControlador.php";

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitalFit - Nuevo Análisis</title>
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

        .form-label {
            font-weight: bold;
        }

        h2 {
            color: #003366;
        }

        .tipo-analisis-badge {
            display: inline-block;
            width: 100%;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .tipo-analisis-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .tipo-seleccionado {
            border: 2px solid #198754;
            box-shadow: 0 0 10px rgba(25, 135, 84, 0.5);
        }
    </style>
    <script>
        function seleccionarTipo(tipo) {

            document.getElementById('tipo_analisis').value = tipo;


            const badges = document.getElementsByClassName('tipo-analisis-badge');
            for (let badge of badges) {
                badge.classList.remove('tipo-seleccionado');
                if (badge.getAttribute('data-tipo') === tipo) {
                    badge.classList.add('tipo-seleccionado');
                }
            }


            mostrarCampoResultado(tipo);
        }

        function mostrarCampoResultado(tipo) {

            document.getElementById('resultado_progreso').style.display = 'none';
            document.getElementById('resultado_nutricion').style.display = 'none';
            document.getElementById('resultado_capacidad').style.display = 'none';
            document.getElementById('resultado_medico').style.display = 'none';
            document.getElementById('resultado_texto').style.display = 'none';


            switch(tipo) {
                case 'Progreso físico':
                    document.getElementById('resultado_progreso').style.display = 'block';
                    break;
                case 'Evaluación nutricional':
                    document.getElementById('resultado_nutricion').style.display = 'block';
                    break;
                case 'Test de capacidad física':
                    document.getElementById('resultado_capacidad').style.display = 'block';
                    break;
                case 'Evaluación médica':
                    document.getElementById('resultado_medico').style.display = 'block';
                    break;
                default:
                    document.getElementById('resultado_texto').style.display = 'block';
            }
        }

        function prepararEnvio() {
            const tipo = document.getElementById('tipo_analisis').value;
            let resultadoFinal = '';


            switch(tipo) {
                case 'Progreso físico':
                    const peso = document.getElementById('peso').value;
                    const altura = document.getElementById('altura').value;
                    const imc = document.getElementById('imc').value;
                    const grasa = document.getElementById('grasa').value;
                    const musculo = document.getElementById('musculo').value;

                    resultadoFinal = `Peso: ${peso} kg, Altura: ${altura} cm, IMC: ${imc}, % Grasa: ${grasa}%, % Músculo: ${musculo}%`;
                    break;

                case 'Evaluación nutricional':
                    const calorias = document.getElementById('calorias').value;
                    const proteinas = document.getElementById('proteinas').value;
                    const carbohidratos = document.getElementById('carbohidratos').value;
                    const grasas = document.getElementById('grasas').value;

                    resultadoFinal = `Calorías diarias: ${calorias}, Proteínas: ${proteinas}g, Carbohidratos: ${carbohidratos}g, Grasas: ${grasas}g`;
                    break;

                case 'Test de capacidad física':
                    const resistencia = document.getElementById('resistencia').value;
                    const fuerza = document.getElementById('fuerza').value;
                    const flexibilidad = document.getElementById('flexibilidad').value;
                    const equilibrio = document.getElementById('equilibrio').value;

                    resultadoFinal = `Resistencia: ${resistencia}/10, Fuerza: ${fuerza}/10, Flexibilidad: ${flexibilidad}/10, Equilibrio: ${equilibrio}/10`;
                    break;

                case 'Evaluación médica':
                    const presion = document.getElementById('presion').value;
                    const pulso = document.getElementById('pulso').value;
                    const oxigeno = document.getElementById('oxigeno').value;
                    const glucosa = document.getElementById('glucosa').value;

                    resultadoFinal = `Presión arterial: ${presion}, Pulso: ${pulso} bpm, Saturación O2: ${oxigeno}%, Glucosa: ${glucosa} mg/dL`;
                    break;

                default:
                    resultadoFinal = document.getElementById('resultado').value;
            }


            document.getElementById('resultado').value = resultadoFinal;


            return true;
        }

        function calcularIMC() {
            const peso = parseFloat(document.getElementById('peso').value);
            const altura = parseFloat(document.getElementById('altura').value);

            if (peso > 0 && altura > 0) {

                const alturaMetros = altura / 100;

                const imc = peso / (alturaMetros * alturaMetros);
                document.getElementById('imc').value = imc.toFixed(2);
            }
        }
    </script>
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
        <h2>Nuevo Análisis</h2>
        <a href="index.php?controlador=analisisdatos&accion=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <form action="index.php?controlador=analisisdatos&accion=guardar" method="post" onsubmit="return prepararEnvio()">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="idcliente" class="form-label">Cliente *</label>
                <select class="form-select" id="idcliente" name="idcliente" required>
                    <option value="">Seleccione un cliente</option>
                    <?php if (isset($clientes) && is_array($clientes) && count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <?php

                            $selected = isset($idCliente) && $idCliente == $cliente->getId() ? 'selected' : '';
                            $nombreCompleto = $cliente->getNombreCompleto();
                            ?>
                            <option value="<?php echo $cliente->getId(); ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($nombreCompleto); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <div class="form-text">
                    <a href="index.php?controlador=cliente&accion=crear" target="_blank">
                        <i class="fas fa-plus-circle"></i> Registrar nuevo cliente
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha" class="form-label">Fecha del Análisis *</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Tipo de Análisis *</label>
            <input type="hidden" id="tipo_analisis" name="tipo_analisis" value="" required>

            <div class="row">
                <div class="col-md-3">
                    <div class="tipo-analisis-badge bg-info text-white" data-tipo="Progreso físico" onclick="seleccionarTipo('Progreso físico')">
                        <i class="fas fa-weight fa-2x mb-2"></i>
                        <div>Progreso físico</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tipo-analisis-badge bg-success text-white" data-tipo="Evaluación nutricional" onclick="seleccionarTipo('Evaluación nutricional')">
                        <i class="fas fa-apple-alt fa-2x mb-2"></i>
                        <div>Evaluación nutricional</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tipo-analisis-badge bg-danger text-white" data-tipo="Test de capacidad física" onclick="seleccionarTipo('Test de capacidad física')">
                        <i class="fas fa-running fa-2x mb-2"></i>
                        <div>Test de capacidad física</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tipo-analisis-badge bg-warning text-white" data-tipo="Evaluación médica" onclick="seleccionarTipo('Evaluación médica')">
                        <i class="fas fa-heartbeat fa-2x mb-2"></i>
                        <div>Evaluación médica</div>
                    </div>
                </div>
            </div>
        </div>


        <input type="hidden" id="resultado" name="resultado" value="">


        <div id="resultado_progreso" style="display: none;">
            <h4 class="mb-3">Datos de Progreso Físico</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="peso" class="form-label">Peso (kg) *</label>
                    <input type="number" class="form-control" id="peso" name="peso" step="0.1" onchange="calcularIMC()">
                </div>
                <div class="col-md-4">
                    <label for="altura" class="form-label">Altura (cm) *</label>
                    <input type="number" class="form-control" id="altura" name="altura" step="0.1" onchange="calcularIMC()">
                </div>
                <div class="col-md-4">
                    <label for="imc" class="form-label">IMC</label>
                    <input type="number" class="form-control" id="imc" name="imc" step="0.01" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="grasa" class="form-label">Porcentaje de Grasa (%)</label>
                    <input type="number" class="form-control" id="grasa" name="grasa" step="0.1">
                </div>
                <div class="col-md-6">
                    <label for="musculo" class="form-label">Porcentaje de Músculo (%)</label>
                    <input type="number" class="form-control" id="musculo" name="musculo" step="0.1">
                </div>
            </div>
        </div>

        <div id="resultado_nutricion" style="display: none;">
            <h4 class="mb-3">Datos de Evaluación Nutricional</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="calorias" class="form-label">Calorías Diarias Recomendadas</label>
                    <input type="number" class="form-control" id="calorias" name="calorias">
                </div>
                <div class="col-md-6">
                    <label for="proteinas" class="form-label">Proteínas (g)</label>
                    <input type="number" class="form-control" id="proteinas" name="proteinas" step="0.1">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="carbohidratos" class="form-label">Carbohidratos (g)</label>
                    <input type="number" class="form-control" id="carbohidratos" name="carbohidratos" step="0.1">
                </div>
                <div class="col-md-6">
                    <label for="grasas" class="form-label">Grasas (g)</label>
                    <input type="number" class="form-control" id="grasas" name="grasas" step="0.1">
                </div>
            </div>
        </div>

        <div id="resultado_capacidad" style="display: none;">
            <h4 class="mb-3">Datos de Test de Capacidad Física</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="resistencia" class="form-label">Resistencia (1-10)</label>
                    <input type="number" class="form-control" id="resistencia" name="resistencia" min="1" max="10" step="1">
                </div>
                <div class="col-md-6">
                    <label for="fuerza" class="form-label">Fuerza (1-10)</label>
                    <input type="number" class="form-control" id="fuerza" name="fuerza" min="1" max="10" step="1">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="flexibilidad" class="form-label">Flexibilidad (1-10)</label>
                    <input type="number" class="form-control" id="flexibilidad" name="flexibilidad" min="1" max="10" step="1">
                </div>
                <div class="col-md-6">
                    <label for="equilibrio" class="form-label">Equilibrio (1-10)</label>
                    <input type="number" class="form-control" id="equilibrio" name="equilibrio" min="1" max="10" step="1">
                </div>
            </div>
        </div>

        <div id="resultado_medico" style="display: none;">
            <h4 class="mb-3">Datos de Evaluación Médica</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="presion" class="form-label">Presión Arterial</label>
                    <input type="text" class="form-control" id="presion" name="presion" placeholder="Ej: 120/80">
                </div>
                <div class="col-md-6">
                    <label for="pulso" class="form-label">Pulso (bpm)</label>
                    <input type="number" class="form-control" id="pulso" name="pulso">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="oxigeno" class="form-label">Saturación O2 (%)</label>
                    <input type="number" class="form-control" id="oxigeno" name="oxigeno" min="0" max="100" step="1">
                </div>
                <div class="col-md-6">
                    <label for="glucosa" class="form-label">Glucosa (mg/dL)</label>
                    <input type="number" class="form-control" id="glucosa" name="glucosa">
                </div>
            </div>
        </div>

        <div id="resultado_texto" style="display: none;">
            <div class="mb-3">
                <label for="resultado_manual" class="form-label">Resultado del análisis *</label>
                <textarea class="form-control" id="resultado_manual" name="resultado_manual" rows="5" placeholder="Ingrese los resultados detallados del análisis"></textarea>
            </div>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Observaciones adicionales o recomendaciones"></textarea>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button type="reset" class="btn btn-outline-secondary me-md-2">Limpiar Formulario</button>
            <button type="submit" class="btn btn-primary">Guardar Análisis</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

    window.onload = function() {
        const clienteSelect = document.getElementById('idcliente');
        if (clienteSelect.value) {
            document.querySelector('.tipo-analisis-badge').focus();
        }
    };
</script>
</body>
</html>
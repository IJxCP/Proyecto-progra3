<?php
require_once 'MVC/Modelo/InscripcionM.php';

class InscripcionControlador {
    public function index() {
        $modelo = new InscripcionM();
        $inscripciones = $modelo->BuscarTodos();
        include 'MVC/Vista/Inscripcion/index.php';
    }

    public function crear() {
        // Si se proporciona un ID de cliente, lo pasamos a la vista
        $idCliente = isset($_GET['idcliente']) ? $_GET['idcliente'] : null;

        // Cargar datos para los desplegables
        require_once 'MVC/Modelo/RegistroClienteM.php';
        $clienteModelo = new RegistroClienteM();
        $clientes = $clienteModelo->BuscarTodos();

        include 'MVC/Vista/Inscripcion/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'MVC/Entidades/Inscripciones.php';
            require_once 'MVC/Modelo/Utilidades.php';

            $inscripcion = new Inscripcion();

            // Establecer propiedades desde POST
            $inscripcion->setIdGestionDatos($_POST['idgestiondatos']);
            $inscripcion->setFechaInscripcion($_POST['fechainscripcion']);

            // Si la fecha de vencimiento no se proporciona, calcularla según el tipo de membresía
            if (empty($_POST['fechavencimiento']) && !empty($_POST['tipomembresia'])) {
                $fechaVencimiento = Utilidades::calcularFechaVencimiento(
                    $_POST['fechainscripcion'],
                    $_POST['tipomembresia']
                );
                $inscripcion->setFechaVencimiento($fechaVencimiento);
            } else {
                $inscripcion->setFechaVencimiento($_POST['fechavencimiento']);
            }

            $inscripcion->setTipoMembresia($_POST['tipomembresia']);
            $inscripcion->setMonto($_POST['monto']);

            $modelo = new InscripcionM();
            $resultado = $modelo->Insertar($inscripcion);

            if ($resultado) {
                $_SESSION['mensaje'] = "Inscripción registrada correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar la inscripción";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=inscripcion&accion=index");
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new InscripcionM();
            $resultado = $modelo->Eliminar($_GET['id']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Inscripción eliminada correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar la inscripción";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=inscripcion&accion=index");
        }
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new InscripcionM();
            $inscripcionCompleta = $modelo->BuscarInscripcionCompleta($id);

            if ($inscripcionCompleta) {
                include 'MVC/Vista/Inscripcion/ver.php';
            } else {
                $_SESSION['mensaje'] = "Inscripción no encontrada";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=inscripcion&accion=index");
            }
        } else {
            header("Location: index.php?controlador=inscripcion&accion=index");
        }
    }

    public function renovar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new InscripcionM();
            $inscripcion = $modelo->BuscarId($id);

            if ($inscripcion) {
                include 'MVC/Vista/Inscripcion/renovar.php';
            } else {
                $_SESSION['mensaje'] = "Inscripción no encontrada";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=inscripcion&accion=index");
            }
        } else {
            header("Location: index.php?controlador=inscripcion&accion=index");
        }
    }

    public function guardarRenovacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idinscripcion'])) {
            // Cargar la inscripción original
            $modelo = new InscripcionM();
            $inscripcionOriginal = $modelo->BuscarId($_POST['idinscripcion']);

            if ($inscripcionOriginal) {
                require_once 'MVC/Entidades/Inscripciones.php';
                require_once 'MVC/Modelo/Utilidades.php';

                $inscripcionNueva = new Inscripcion();

                // Copiar datos de la inscripción original
                $inscripcionNueva->setIdGestionDatos($inscripcionOriginal->getIdGestionDatos());

                // Establecer fechas de la nueva inscripción
                $fechaInicio = date('Y-m-d'); // Hoy
                $inscripcionNueva->setFechaInscripcion($fechaInicio);

                // Calcular fecha de vencimiento
                $tipoMembresia = $_POST['tipomembresia'];
                $fechaVencimiento = Utilidades::calcularFechaVencimiento($fechaInicio, $tipoMembresia);
                $inscripcionNueva->setFechaVencimiento($fechaVencimiento);

                // Otros datos
                $inscripcionNueva->setTipoMembresia($tipoMembresia);
                $inscripcionNueva->setMonto($_POST['monto']);

                $resultado = $modelo->Insertar($inscripcionNueva);

                if ($resultado) {
                    $_SESSION['mensaje'] = "Inscripción renovada correctamente";
                    $_SESSION['tipo_mensaje'] = "success";
                } else {
                    $_SESSION['mensaje'] = "Error al renovar la inscripción";
                    $_SESSION['tipo_mensaje'] = "danger";
                }
            } else {
                $_SESSION['mensaje'] = "Inscripción original no encontrada";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=inscripcion&accion=index");
        }
    }
}
<?php
require_once 'MVC/Modelo/GestionCuotasM.php';

class CuotaControlador {
    public function index() {
        $modelo = new GestionCuotasM();
        $cuotas = $modelo->BuscarTodos();
        include 'MVC/Vista/Cuotas/index.php';
    }

    public function crear() {
        include 'MVC/Vista/Cuotas/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelo = new GestionCuotasM();

            require_once 'MVC/Entidades/GestionCuotas.php';
            $cuota = new GestionCuotas();
            $cuota->setIdInscripcion($_POST['idinscripcion']);
            $cuota->setFechaPago($_POST['fechapago']);
            $cuota->setMonto($_POST['monto']);
            $cuota->setMetodoPago($_POST['metodopago']);
            $cuota->setComprobante($_POST['comprobante'] ?? '');
            $cuota->setEstado($_POST['estado']);
            $cuota->setObservaciones($_POST['observaciones'] ?? '');

            $resultado = $modelo->Insertar($cuota);

            if ($resultado) {
                $_SESSION['mensaje'] = "Cuota registrada correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar la cuota";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=cuota&accion=index");
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new GestionCuotasM();
            $resultado = $modelo->Eliminar($_GET['id']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Cuota eliminada correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar la cuota";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=cuota&accion=index");
        }
    }
}
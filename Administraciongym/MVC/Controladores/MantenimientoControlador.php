<?php
require_once 'MVC/Modelo/MantenimientoM.php';

class MantenimientoControlador {
    public function index() {
        $modelo = new MantenimientoM();
        $mantenimientos = $modelo->listar();
        include 'MVC/Vista/Mantenimiento/mantenimiento.php';
    }

    public function crear() {
        include 'MVC/Vista/Mantenimiento/mantenimiento.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'MVC/Entidades/Mantenimiento.php';
            $mantenimiento = new Mantenimiento();

            // Establecer los datos desde POST
            $mantenimiento->setDescripcion($_POST['descripcion']);
            $mantenimiento->setFecha($_POST['fecha'] ?? date('Y-m-d'));
            $mantenimiento->setResponsable($_POST['responsable'] ?? '');
            $mantenimiento->setEstado($_POST['estado'] ?? 'Pendiente');

            $modelo = new MantenimientoM();
            $resultado = $modelo->insertar($mantenimiento);

            if ($resultado) {
                $_SESSION['mensaje'] = "Mantenimiento registrado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar el mantenimiento";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=mantenimiento&accion=index");
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new MantenimientoM();
            $mantenimiento = $modelo->obtenerPorId($id);

            if ($mantenimiento) {
                include 'MVC/Vista/Mantenimiento/editar.php';
            } else {
                $_SESSION['mensaje'] = "Mantenimiento no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=mantenimiento&accion=index");
            }
        } else {
            header("Location: index.php?controlador=mantenimiento&accion=index");
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once 'MVC/Entidades/Mantenimiento.php';
            $mantenimiento = new Mantenimiento();

            // Establecer los datos desde POST
            $mantenimiento->setId($_POST['id']);
            $mantenimiento->setDescripcion($_POST['descripcion']);
            $mantenimiento->setFecha($_POST['fecha']);
            $mantenimiento->setResponsable($_POST['responsable']);
            $mantenimiento->setEstado($_POST['estado']);

            $modelo = new MantenimientoM();
            $resultado = $modelo->actualizar($mantenimiento);

            if ($resultado) {
                $_SESSION['mensaje'] = "Mantenimiento actualizado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el mantenimiento";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=mantenimiento&accion=index");
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new MantenimientoM();
            $resultado = $modelo->eliminar($_GET['id']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Mantenimiento eliminado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el mantenimiento";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=mantenimiento&accion=index");
        }
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new MantenimientoM();
            $mantenimiento = $modelo->obtenerPorId($id);

            if ($mantenimiento) {
                include 'MVC/Vista/Mantenimiento/ver.php';
            } else {
                $_SESSION['mensaje'] = "Mantenimiento no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=mantenimiento&accion=index");
            }
        } else {
            header("Location: index.php?controlador=mantenimiento&accion=index");
        }
    }

    // Método para filtrar por estado
    public function filtrarPorEstado() {
        if (isset($_GET['estado'])) {
            $estado = $_GET['estado'];
            $modelo = new MantenimientoM();
            $mantenimientos = $modelo->filtrarPorEstado($estado);
            include 'MVC/Vista/Mantenimiento/index.php';
        } else {
            header("Location: index.php?controlador=mantenimiento&accion=index");
        }
    }

    // Método para buscar por descripción o responsable
    public function buscar() {
        if (isset($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];
            $modelo = new MantenimientoM();
            $mantenimientos = $modelo->buscarPorDescripcionOResponsable($busqueda);
            include 'MVC/Vista/Mantenimiento/index.php';
        } else {
            header("Location: index.php?controlador=mantenimiento&accion=index");
        }
    }
}
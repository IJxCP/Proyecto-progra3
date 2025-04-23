<?php
require_once 'MVC/Modelo/StatusM.php';

class StatusControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new StatusM();
    }

    public function index() {
        $status = $this->modelo->BuscarTodos();
        include 'MVC/Vista/status/index.php';
    }

    public function crear() {
        include 'MVC/Vista/status/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = new Status();
            $status->setNombre($_POST['nombre']);
            $status->setDescripcion($_POST['descripcion']);

            if ($this->modelo->Insertar($status)) {
                $_SESSION['mensaje'] = "Status creado correctamente";
                $_SESSION['mensaje_tipo'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al crear el status";
                $_SESSION['mensaje_tipo'] = "danger";
            }

            header("Location: index.php?controlador=status&accion=index");
            exit();
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $status = $this->modelo->BuscarId($id);

            if ($status) {
                include 'MVC/Vista/status/editar.php';
            } else {
                $_SESSION['mensaje'] = "Status no encontrado";
                $_SESSION['mensaje_tipo'] = "danger";
                header("Location: index.php?controlador=status&accion=index");
                exit();
            }
        } else {
            header("Location: index.php?controlador=status&accion=index");
            exit();
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $status = new Status();
            $status->setId($_POST['id']);
            $status->setNombre($_POST['nombre']);
            $status->setDescripcion($_POST['descripcion']);

            if ($this->modelo->Actualizar($status)) {
                $_SESSION['mensaje'] = "Status actualizado correctamente";
                $_SESSION['mensaje_tipo'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el status";
                $_SESSION['mensaje_tipo'] = "danger";
            }

            header("Location: index.php?controlador=status&accion=index");
            exit();
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            // Verificar si el status está en uso antes de eliminar
            require_once 'MVC/Modelo/GestionDatosM.php';
            $gestionDatosM = new GestionDatosM();
            $gestionesConStatus = $gestionDatosM->BuscarPorStatus($_GET['id']);

            if (!empty($gestionesConStatus)) {
                $_SESSION['mensaje'] = "No se puede eliminar el status porque está en uso";
                $_SESSION['mensaje_tipo'] = "warning";
            } else {
                if ($this->modelo->Eliminar($_GET['id'])) {
                    $_SESSION['mensaje'] = "Status eliminado correctamente";
                    $_SESSION['mensaje_tipo'] = "success";
                } else {
                    $_SESSION['mensaje'] = "Error al eliminar el status";
                    $_SESSION['mensaje_tipo'] = "danger";
                }
            }

            header("Location: index.php?controlador=status&accion=index");
            exit();
        }
    }
}
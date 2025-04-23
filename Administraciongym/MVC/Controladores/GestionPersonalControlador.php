<?php
require_once 'MVC/Modelo/GestionPersonalM.php';

class GestionPersonalControlador {
    public function index() {
        $modelo = new GestionPersonalM();
        $personal = $modelo->listar();
        include 'MVC/Vista/Personal/index.php';
    }

    public function crear() {
        include 'MVC/Vista/Personal/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'MVC/Entidades/GestionPersonal.php';
            $personal = new GestionPersonal();

            // Establecer los datos desde POST
            $personal->setNombre($_POST['nombre_completo']);
            $personal->setPuesto($_POST['puesto']);
            $personal->setFechaIngreso($_POST['fecha_ingreso']);
            $personal->setCorreo($_POST['correo']);
            $personal->setTelefono($_POST['telefono']);
            $personal->setEstado($_POST['estado']);

            $modelo = new GestionPersonalM();
            $resultado = $modelo->insertar($personal);

            if ($resultado) {
                // Establecer mensaje de éxito en la sesión
                $_SESSION['mensaje'] = "Personal registrado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                // Establecer mensaje de error en la sesión
                $_SESSION['mensaje'] = "Error al registrar el personal";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=gestionpersonal&accion=index");
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new GestionPersonalM();
            $personal = $modelo->obtenerPorId($id);

            if ($personal) {
                include 'MVC/Vista/Personal/editar.php';
            } else {
                $_SESSION['mensaje'] = "Personal no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=gestionpersonal&accion=index");
            }
        } else {
            header("Location: index.php?controlador=gestionpersonal&accion=index");
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once 'MVC/Entidades/GestionPersonal.php';
            $personal = new GestionPersonal();

            // Establecer los datos desde POST
            $personal->setId($_POST['id']);
            $personal->setNombre($_POST['nombre_completo']);
            $personal->setPuesto($_POST['puesto']);
            $personal->setFechaIngreso($_POST['fecha_ingreso']);
            $personal->setCorreo($_POST['correo']);
            $personal->setTelefono($_POST['telefono']);
            $personal->setEstado($_POST['estado']);

            $modelo = new GestionPersonalM();
            $resultado = $modelo->actualizar($personal);

            if ($resultado) {
                $_SESSION['mensaje'] = "Personal actualizado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el personal";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=gestionpersonal&accion=index");
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new GestionPersonalM();
            $resultado = $modelo->eliminar($_GET['id']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Personal eliminado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el personal";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=gestionpersonal&accion=index");
        }
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new GestionPersonalM();
            $personal = $modelo->obtenerPorId($id);

            if ($personal) {
                include 'MVC/Vista/Personal/ver.php';
            } else {
                $_SESSION['mensaje'] = "Personal no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=gestionpersonal&accion=index");
            }
        } else {
            header("Location: index.php?controlador=gestionpersonal&accion=index");
        }
    }
}
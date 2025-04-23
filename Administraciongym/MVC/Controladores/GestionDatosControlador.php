<?php
require_once 'MVC/Modelo/GestionDatosM.php';

class GestionDatosControlador {
    public function index() {
        $modelo = new GestionDatosM();
        $gestiones = $modelo->BuscarTodos();
        include 'MVC/Vista/GestionDatos/index.php';
    }

    public function crear() {
        // Si se proporciona un ID de cliente, lo pasamos a la vista
        $idCliente = isset($_GET['idcliente']) ? $_GET['idcliente'] : null;

        // Cargar datos para los desplegables
        require_once 'MVC/Modelo/RegistroClienteM.php';
        require_once 'MVC/Modelo/StatusM.php';

        $clienteModelo = new RegistroClienteM();
        $statusModelo = new StatusM();

        $clientes = $clienteModelo->BuscarTodos();
        $estados = $statusModelo->BuscarTodos();

        include 'MVC/Vista/GestionDatos/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'MVC/Entidades/GestionDatos.php';

            $gestionDatos = new GestionDatos();
            $gestionDatos->setIdCliente($_POST['idcliente']);
            $gestionDatos->setIdStatus($_POST['idstatus']);
            $gestionDatos->setFechaUltimaActualizacion($_POST['fechaultimaactualizacion'] ?? date('Y-m-d'));
            $gestionDatos->setObservaciones($_POST['observaciones'] ?? '');

            $modelo = new GestionDatosM();
            $resultado = $modelo->Insertar($gestionDatos);

            if ($resultado) {
                $_SESSION['mensaje'] = "Status del cliente actualizado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el status del cliente";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=gestiondatos&accion=index");
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new GestionDatosM();
            $gestionDatos = $modelo->BuscarGestionConClienteYStatus($id);

            if ($gestionDatos) {
                // Cargar datos para los desplegables
                require_once 'MVC/Modelo/StatusM.php';
                $statusModelo = new StatusM();
                $estados = $statusModelo->BuscarTodos();

                include 'MVC/Vista/GestionDatos/editar.php';
            } else {
                $_SESSION['mensaje'] = "Registro no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=gestiondatos&accion=index");
            }
        } else {
            header("Location: index.php?controlador=gestiondatos&accion=index");
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once 'MVC/Entidades/GestionDatos.php';

            $gestionDatos = new GestionDatos();
            $gestionDatos->setId($_POST['id']);
            $gestionDatos->setIdCliente($_POST['idcliente']);
            $gestionDatos->setIdStatus($_POST['idstatus']);
            $gestionDatos->setFechaUltimaActualizacion($_POST['fechaultimaactualizacion']);
            $gestionDatos->setObservaciones($_POST['observaciones'] ?? '');

            $modelo = new GestionDatosM();
            $resultado = $modelo->Actualizar($gestionDatos);

            if ($resultado) {
                $_SESSION['mensaje'] = "Status del cliente actualizado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el status del cliente";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=gestiondatos&accion=index");
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new GestionDatosM();
            $resultado = $modelo->Eliminar($_GET['id']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Registro eliminado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el registro";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=gestiondatos&accion=index");
        }
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new GestionDatosM();
            $gestionDatos = $modelo->BuscarGestionConClienteYStatus($id);

            if ($gestionDatos) {
                include 'MVC/Vista/GestionDatos/ver.php';
            } else {
                $_SESSION['mensaje'] = "Registro no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=gestiondatos&accion=index");
            }
        } else {
            header("Location: index.php?controlador=gestiondatos&accion=index");
        }
    }

    // Método para filtrar por status
    public function filtrarPorStatus() {
        if (isset($_GET['idstatus'])) {
            $idStatus = $_GET['idstatus'];
            $modelo = new GestionDatosM();
            $gestiones = $modelo->BuscarPorStatus($idStatus);

            require_once 'MVC/Modelo/StatusM.php';
            $statusModelo = new StatusM();
            $statusActual = $statusModelo->BuscarId($idStatus);

            include 'MVC/Vista/GestionDatos/index.php';
        } else {
            header("Location: index.php?controlador=gestiondatos&accion=index");
        }
    }

    // Método para buscar por cliente
    public function buscarPorCliente() {
        if (isset($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];
            $modelo = new GestionDatosM();
            $gestiones = $modelo->BuscarPorNombreCliente($busqueda);
            include 'MVC/Vista/GestionDatos/index.php';
        } else {
            header("Location: index.php?controlador=gestiondatos&accion=index");
        }
    }
}
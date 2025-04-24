<?php
require_once 'MVC/Modelo/AnalisisDatosM.php';

class AnalisisDatosControlador {
    public function index() {
        $modelo = new AnalisisDatosM();
        $analisis = $modelo->listar();
        include 'MVC/Vista/Analisis/index.php';
    }

    public function crear() {
        // Si se proporciona un ID de cliente, lo pasamos a la vista
        $idCliente = isset($_GET['idcliente']) ? $_GET['idcliente'] : null;

        // Cargar datos para los desplegables
        require_once 'MVC/Modelo/RegistroClienteM.php';
        $clienteModelo = new RegistroClienteM();
        $clientes = $clienteModelo->BuscarTodos();

        include 'MVC/Vista/Analisis/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'MVC/Entidades/AnalisisDatos.php';

            $analisis = new AnalisisDatos();
            $analisis->setIdcliente($_POST['idcliente']);
            $analisis->setFecha($_POST['fecha'] ?? date('Y-m-d'));
            $analisis->setTipoAnalisis($_POST['tipo_analisis'] ?? '');
            $analisis->setResultado($_POST['resultado'] ?? '');
            $analisis->setObservaciones($_POST['observaciones'] ?? '');

            $modelo = new AnalisisDatosM();
            $resultado = $modelo->insertar($analisis);

            if ($resultado) {
                $_SESSION['mensaje'] = "Análisis registrado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar el análisis";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new AnalisisDatosM();
            $analisis = $modelo->obtenerPorId($id);

            if ($analisis) {
                // Cargar datos para los desplegables
                require_once 'MVC/Modelo/RegistroClienteM.php';
                $clienteModelo = new RegistroClienteM();
                $clientes = $clienteModelo->BuscarTodos();

                include 'MVC/Vista/Analisis/editar.php';
            } else {
                $_SESSION['mensaje'] = "Análisis no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=analisisdatos&accion=index");
            }
        } else {
            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once 'MVC/Entidades/AnalisisDatos.php';

            $analisis = new AnalisisDatos();
            $analisis->setId($_POST['id']);
            $analisis->setIdcliente($_POST['idcliente']);
            $analisis->setFecha($_POST['fecha']);
            $analisis->setTipoAnalisis($_POST['tipo_analisis']);
            $analisis->setResultado($_POST['resultado']);
            $analisis->setObservaciones($_POST['observaciones'] ?? '');

            $modelo = new AnalisisDatosM();
            $resultado = $modelo->actualizar($analisis);

            if ($resultado) {
                $_SESSION['mensaje'] = "Análisis actualizado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el análisis";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new AnalisisDatosM();
            $resultado = $modelo->eliminar($_GET['id']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Análisis eliminado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el análisis";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new AnalisisDatosM();
            $analisis = $modelo->obtenerAnalisisCompleto($id);

            if ($analisis) {
                include 'MVC/Vista/Analisis/ver.php';
            } else {
                $_SESSION['mensaje'] = "Análisis no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=analisisdatos&accion=index");
            }
        } else {
            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }

    // Método para filtrar análisis por cliente
    public function filtrarPorCliente() {
        if (isset($_GET['idcliente'])) {
            $idCliente = $_GET['idcliente'];
            $modelo = new AnalisisDatosM();
            $analisis = $modelo->obtenerPorCliente($idCliente);

            require_once 'MVC/Modelo/RegistroClienteM.php';
            $clienteModelo = new RegistroClienteM();
            $cliente = $clienteModelo->BuscarClienteCompleto($idCliente);

            include 'MVC/Vista/Analisis/index.php';
        } else {
            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }

    // Método para filtrar análisis por tipo
    public function filtrarPorTipo() {
        if (isset($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
            $modelo = new AnalisisDatosM();
            $analisis = $modelo->obtenerPorTipo($tipo);

            include 'MVC/Vista/Analisis/index.php';
        } else {
            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }

    // Método para buscar análisis por texto
    public function buscar() {
        if (isset($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];
            $modelo = new AnalisisDatosM();
            $analisis = $modelo->buscarPorTexto($busqueda);

            include 'MVC/Vista/Analisis/index.php';
        } else {
            header("Location: index.php?controlador=analisisdatos&accion=index");
        }
    }
}
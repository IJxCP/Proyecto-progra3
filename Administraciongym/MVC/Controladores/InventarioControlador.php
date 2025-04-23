<?php
require_once 'MVC/Modelo/StockM.php';

class InventarioControlador {
    public function index() {
        $modelo = new StockM();
        $items = $modelo->listar();
        include 'MVC/Vista/Stock/Stock.php';
    }

    public function crear() {
        include 'MVC/Vista/Stock/Stock.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'MVC/Entidades/Stock.php';
            $item = new Stock();

            // Establecer los datos desde POST
            $item->setNombreItem($_POST['nombre_item']);
            $item->setDescripcion(isset($_POST['descripcion']) ? $_POST['descripcion'] : '');
            $item->setCantidad($_POST['cantidad']);
            $item->setCategoria(isset($_POST['categoria']) ? $_POST['categoria'] : '');
            $item->setFechaIngreso($_POST['fecha_ingreso'] ?? date('Y-m-d'));
            $item->setEstado($_POST['estado'] ?? 'Disponible');

            $modelo = new StockM();
            $resultado = $modelo->insertar($item);

            if ($resultado) {
                $_SESSION['mensaje'] = "Item registrado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al registrar el item";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=inventario&accion=index");
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new StockM();
            $item = $modelo->obtenerPorId($id);

            if ($item) {
                include 'MVC/Vista/Inventario/editar.php';
            } else {
                $_SESSION['mensaje'] = "Item no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=inventario&accion=index");
            }
        } else {
            header("Location: index.php?controlador=inventario&accion=index");
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            require_once 'MVC/Entidades/Stock.php';
            $item = new Stock();

            // Establecer los datos desde POST
            $item->setId($_POST['id']);
            $item->setNombreItem($_POST['nombre_item']);
            $item->setDescripcion($_POST['descripcion'] ?? '');
            $item->setCantidad($_POST['cantidad']);
            $item->setCategoria($_POST['categoria'] ?? '');
            $item->setFechaIngreso($_POST['fecha_ingreso'] ?? date('Y-m-d'));
            $item->setEstado($_POST['estado'] ?? 'Disponible');

            $modelo = new StockM();
            $resultado = $modelo->actualizar($item);

            if ($resultado) {
                $_SESSION['mensaje'] = "Item actualizado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el item";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=inventario&accion=index");
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new StockM();
            $resultado = $modelo->eliminar($_GET['id']);

            if ($resultado) {
                $_SESSION['mensaje'] = "Item eliminado correctamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el item";
                $_SESSION['tipo_mensaje'] = "danger";
            }

            header("Location: index.php?controlador=inventario&accion=index");
        }
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $modelo = new StockM();
            $item = $modelo->obtenerPorId($id);

            if ($item) {
                include 'MVC/Vista/Inventario/ver.php';
            } else {
                $_SESSION['mensaje'] = "Item no encontrado";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?controlador=inventario&accion=index");
            }
        } else {
            header("Location: index.php?controlador=inventario&accion=index");
        }
    }

    // Método para buscar items por nombre o categoría
    public function buscar() {
        if (isset($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];
            $modelo = new StockM();
            $items = $modelo->buscarPorNombreOCategoria($busqueda);
            include 'MVC/Vista/Inventario/index.php';
        } else {
            header("Location: index.php?controlador=inventario&accion=index");
        }
    }

    // Método para filtrar por categoría
    public function filtrarPorCategoria() {
        if (isset($_GET['categoria'])) {
            $categoria = $_GET['categoria'];
            $modelo = new StockM();
            $items = $modelo->filtrarPorCategoria($categoria);
            include 'MVC/Vista/Inventario/index.php';
        } else {
            header("Location: index.php?controlador=inventario&accion=index");
        }
    }

    // Método para listar categorías únicas para el filtro
    public function obtenerCategorias() {
        $modelo = new StockM();
        return $modelo->obtenerCategorias();
    }
}
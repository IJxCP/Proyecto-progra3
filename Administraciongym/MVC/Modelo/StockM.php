<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/Stock.php';

class StockM {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar() {
        $listaStock = array();
        $sql = "SELECT id, nombre_item, descripcion, cantidad, categoria, fecha_ingreso, estado 
                FROM inventario ORDER BY nombre_item;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $item = new Stock();
                $item->setId($fila['id']);
                $item->setNombreItem($fila['nombre_item']);
                $item->setDescripcion($fila['descripcion']);
                $item->setCantidad($fila['cantidad']);
                $item->setCategoria($fila['categoria']);
                $item->setFechaIngreso($fila['fecha_ingreso']);
                $item->setEstado($fila['estado']);
                $listaStock[] = $item;
            }
        }

        $this->conexion->Cerrar();
        return $listaStock;
    }

    public function obtenerPorId($id) {
        $item = null;
        $id = (int)$id; // Asegurar que es un entero
        $sql = "SELECT id, nombre_item, descripcion, cantidad, categoria, fecha_ingreso, estado 
                FROM inventario WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $item = new Stock();
            $item->setId($fila['id']);
            $item->setNombreItem($fila['nombre_item']);
            $item->setDescripcion($fila['descripcion']);
            $item->setCantidad($fila['cantidad']);
            $item->setCategoria($fila['categoria']);
            $item->setFechaIngreso($fila['fecha_ingreso']);
            $item->setEstado($fila['estado']);
        }

        $this->conexion->Cerrar();
        return $item;
    }

    public function insertar(Stock $item) {
        $nombreItem = $this->conexion->mysqli->real_escape_string($item->getNombreItem());
        $descripcion = $this->conexion->mysqli->real_escape_string($item->getDescripcion());
        $cantidad = (int)$item->getCantidad();
        $categoria = $this->conexion->mysqli->real_escape_string($item->getCategoria());
        $fechaIngreso = $this->conexion->mysqli->real_escape_string($item->getFechaIngreso());
        $estado = $this->conexion->mysqli->real_escape_string($item->getEstado());

        $sql = "INSERT INTO inventario (nombre_item, descripcion, cantidad, categoria, fecha_ingreso, estado) 
                VALUES ('$nombreItem', '$descripcion', $cantidad, '$categoria', '$fechaIngreso', '$estado');";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $this->conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $item->setId($id);
        }

        $this->conexion->Cerrar();
        return $resultado;
    }

    public function actualizar(Stock $item) {
        $id = (int)$item->getId(); // Asegurar que es un entero
        $nombreItem = $this->conexion->mysqli->real_escape_string($item->getNombreItem());
        $descripcion = $this->conexion->mysqli->real_escape_string($item->getDescripcion());
        $cantidad = (int)$item->getCantidad();
        $categoria = $this->conexion->mysqli->real_escape_string($item->getCategoria());
        $fechaIngreso = $this->conexion->mysqli->real_escape_string($item->getFechaIngreso());
        $estado = $this->conexion->mysqli->real_escape_string($item->getEstado());

        $sql = "UPDATE inventario SET
                nombre_item = '$nombreItem',
                descripcion = '$descripcion',
                cantidad = $cantidad,
                categoria = '$categoria',
                fecha_ingreso = '$fechaIngreso',
                estado = '$estado'
                WHERE id = $id;";

        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    public function eliminar($id) {
        $id = (int)$id; // Asegurar que es un entero
        $sql = "DELETE FROM inventario WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    // Método para buscar por nombre o categoría
    public function buscarPorNombreOCategoria($busqueda) {
        $listaStock = array();
        $busqueda = $this->conexion->mysqli->real_escape_string($busqueda);

        $sql = "SELECT id, nombre_item, descripcion, cantidad, categoria, fecha_ingreso, estado 
                FROM inventario 
                WHERE nombre_item LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'
                ORDER BY nombre_item;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $item = new Stock();
                $item->setId($fila['id']);
                $item->setNombreItem($fila['nombre_item']);
                $item->setDescripcion($fila['descripcion']);
                $item->setCantidad($fila['cantidad']);
                $item->setCategoria($fila['categoria']);
                $item->setFechaIngreso($fila['fecha_ingreso']);
                $item->setEstado($fila['estado']);
                $listaStock[] = $item;
            }
        }

        $this->conexion->Cerrar();
        return $listaStock;
    }

    // Método para filtrar por categoría
    public function filtrarPorCategoria($categoria) {
        $listaStock = array();
        $categoria = $this->conexion->mysqli->real_escape_string($categoria);

        $sql = "SELECT id, nombre_item, descripcion, cantidad, categoria, fecha_ingreso, estado 
                FROM inventario 
                WHERE categoria = '$categoria'
                ORDER BY nombre_item;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $item = new Stock();
                $item->setId($fila['id']);
                $item->setNombreItem($fila['nombre_item']);
                $item->setDescripcion($fila['descripcion']);
                $item->setCantidad($fila['cantidad']);
                $item->setCategoria($fila['categoria']);
                $item->setFechaIngreso($fila['fecha_ingreso']);
                $item->setEstado($fila['estado']);
                $listaStock[] = $item;
            }
        }

        $this->conexion->Cerrar();
        return $listaStock;
    }

    // Método para obtener todas las categorías únicas
    public function obtenerCategorias() {
        $categorias = array();

        $sql = "SELECT DISTINCT categoria FROM inventario WHERE categoria != '' ORDER BY categoria;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $categorias[] = $fila['categoria'];
            }
        }

        $this->conexion->Cerrar();
        return $categorias;
    }

    // Método para actualizar la cantidad de un item específico
    public function actualizarCantidad($id, $nuevaCantidad) {
        $id = (int)$id; // Asegurar que es un entero
        $nuevaCantidad = (int)$nuevaCantidad;

        $sql = "UPDATE inventario SET cantidad = $nuevaCantidad WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);

        $this->conexion->Cerrar();
        return $resultado;
    }
}
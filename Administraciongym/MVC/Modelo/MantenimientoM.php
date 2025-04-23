<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/Mantenimiento.php';

class MantenimientoM {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar() {
        $listaMantenimientos = array();
        $sql = "SELECT id, descripcion, fecha, responsable, estado 
                FROM mantenimiento ORDER BY fecha DESC;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $mantenimiento = new Mantenimiento();
                $mantenimiento->setId($fila['id']);
                $mantenimiento->setDescripcion($fila['descripcion']);
                $mantenimiento->setFecha($fila['fecha']);
                $mantenimiento->setResponsable($fila['responsable']);
                $mantenimiento->setEstado($fila['estado']);
                $listaMantenimientos[] = $mantenimiento;
            }
        }

        $this->conexion->Cerrar();
        return $listaMantenimientos;
    }

    public function obtenerPorId($id) {
        $mantenimiento = null;
        $id = (int)$id; // Asegurar que es un entero
        $sql = "SELECT id, descripcion, fecha, responsable, estado 
                FROM mantenimiento WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $mantenimiento = new Mantenimiento();
            $mantenimiento->setId($fila['id']);
            $mantenimiento->setDescripcion($fila['descripcion']);
            $mantenimiento->setFecha($fila['fecha']);
            $mantenimiento->setResponsable($fila['responsable']);
            $mantenimiento->setEstado($fila['estado']);
        }

        $this->conexion->Cerrar();
        return $mantenimiento;
    }

    public function insertar(Mantenimiento $mantenimiento) {
        $descripcion = $this->conexion->mysqli->real_escape_string($mantenimiento->getDescripcion());
        $fecha = $this->conexion->mysqli->real_escape_string($mantenimiento->getFecha());
        $responsable = $this->conexion->mysqli->real_escape_string($mantenimiento->getResponsable());
        $estado = $this->conexion->mysqli->real_escape_string($mantenimiento->getEstado());

        $sql = "INSERT INTO mantenimiento (descripcion, fecha, responsable, estado) 
                VALUES ('$descripcion', '$fecha', '$responsable', '$estado');";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $this->conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $mantenimiento->setId($id);
        }

        $this->conexion->Cerrar();
        return $resultado;
    }

    public function actualizar(Mantenimiento $mantenimiento) {
        $id = (int)$mantenimiento->getId(); // Asegurar que es un entero
        $descripcion = $this->conexion->mysqli->real_escape_string($mantenimiento->getDescripcion());
        $fecha = $this->conexion->mysqli->real_escape_string($mantenimiento->getFecha());
        $responsable = $this->conexion->mysqli->real_escape_string($mantenimiento->getResponsable());
        $estado = $this->conexion->mysqli->real_escape_string($mantenimiento->getEstado());

        $sql = "UPDATE mantenimiento SET
                descripcion = '$descripcion',
                fecha = '$fecha',
                responsable = '$responsable',
                estado = '$estado'
                WHERE id = $id;";

        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    public function eliminar($id) {
        $id = (int)$id; // Asegurar que es un entero
        $sql = "DELETE FROM mantenimiento WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    // Método para filtrar por estado
    public function filtrarPorEstado($estado) {
        $listaMantenimientos = array();
        $estado = $this->conexion->mysqli->real_escape_string($estado);

        $sql = "SELECT id, descripcion, fecha, responsable, estado 
                FROM mantenimiento 
                WHERE estado = '$estado'
                ORDER BY fecha DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $mantenimiento = new Mantenimiento();
                $mantenimiento->setId($fila['id']);
                $mantenimiento->setDescripcion($fila['descripcion']);
                $mantenimiento->setFecha($fila['fecha']);
                $mantenimiento->setResponsable($fila['responsable']);
                $mantenimiento->setEstado($fila['estado']);
                $listaMantenimientos[] = $mantenimiento;
            }
        }

        $this->conexion->Cerrar();
        return $listaMantenimientos;
    }

    // Método para buscar por descripción o responsable
    public function buscarPorDescripcionOResponsable($busqueda) {
        $listaMantenimientos = array();
        $busqueda = $this->conexion->mysqli->real_escape_string($busqueda);

        $sql = "SELECT id, descripcion, fecha, responsable, estado 
                FROM mantenimiento 
                WHERE descripcion LIKE '%$busqueda%' OR responsable LIKE '%$busqueda%'
                ORDER BY fecha DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $mantenimiento = new Mantenimiento();
                $mantenimiento->setId($fila['id']);
                $mantenimiento->setDescripcion($fila['descripcion']);
                $mantenimiento->setFecha($fila['fecha']);
                $mantenimiento->setResponsable($fila['responsable']);
                $mantenimiento->setEstado($fila['estado']);
                $listaMantenimientos[] = $mantenimiento;
            }
        }

        $this->conexion->Cerrar();
        return $listaMantenimientos;
    }

    // Método para obtener mantenimientos pendientes
    public function obtenerMantenimientosPendientes() {
        return $this->filtrarPorEstado('Pendiente');
    }

    // Método para obtener mantenimientos completados
    public function obtenerMantenimientosCompletados() {
        return $this->filtrarPorEstado('Completado');
    }

    // Método para obtener mantenimientos por fecha
    public function obtenerPorFecha($fecha) {
        $listaMantenimientos = array();
        $fecha = $this->conexion->mysqli->real_escape_string($fecha);

        $sql = "SELECT id, descripcion, fecha, responsable, estado 
                FROM mantenimiento 
                WHERE fecha = '$fecha'
                ORDER BY id;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $mantenimiento = new Mantenimiento();
                $mantenimiento->setId($fila['id']);
                $mantenimiento->setDescripcion($fila['descripcion']);
                $mantenimiento->setFecha($fila['fecha']);
                $mantenimiento->setResponsable($fila['responsable']);
                $mantenimiento->setEstado($fila['estado']);
                $listaMantenimientos[] = $mantenimiento;
            }
        }

        $this->conexion->Cerrar();
        return $listaMantenimientos;
    }
}
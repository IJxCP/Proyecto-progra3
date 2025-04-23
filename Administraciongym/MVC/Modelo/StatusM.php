<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/Status.php';

class StatusM {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function BuscarId($id) {
        $status = new Status();
        $sql = "SELECT id, nombre, descripcion FROM status WHERE id = $id";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $status->setId($fila['id']);
            $status->setNombre($fila['nombre']);
            $status->setDescripcion($fila['descripcion']);
        } else {
            $status = null;
        }

        return $status;
    }

    public function BuscarTodos() {
        $listaStatus = array();
        $sql = "SELECT id, nombre, descripcion FROM status";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $status = new Status();
                $status->setId($fila['id']);
                $status->setNombre($fila['nombre']);
                $status->setDescripcion($fila['descripcion']);
                $listaStatus[] = $status;
            }
        }

        return $listaStatus;
    }

    public function Insertar(Status $status) {
        $nombre = $status->getNombre();
        $descripcion = $status->getDescripcion();

        // Escapar las cadenas para evitar inyección SQL
        $nombre = $this->conexion->mysqli->real_escape_string($nombre);
        $descripcion = $this->conexion->mysqli->real_escape_string($descripcion);

        $sql = "INSERT INTO status (nombre, descripcion) VALUES ('$nombre', '$descripcion')";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $this->conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $status->setId($id);
        }

        return $resultado;
    }

    public function Actualizar(Status $status) {
        $id = $status->getId();
        $nombre = $status->getNombre();
        $descripcion = $status->getDescripcion();

        // Escapar las cadenas para evitar inyección SQL
        $nombre = $this->conexion->mysqli->real_escape_string($nombre);
        $descripcion = $this->conexion->mysqli->real_escape_string($descripcion);

        $sql = "UPDATE status SET nombre = '$nombre', descripcion = '$descripcion' WHERE id = $id";

        return $this->conexion->Ejecutar($sql);
    }

    public function Eliminar($id) {
        $sql = "DELETE FROM status WHERE id = $id";
        return $this->conexion->Ejecutar($sql);
    }

    // Método para buscar por nombre
    public function BuscarPorNombre($nombre) {
        $status = null;
        $nombreEsc = $this->conexion->mysqli->real_escape_string($nombre);

        $sql = "SELECT id, nombre, descripcion FROM status WHERE nombre = '$nombreEsc'";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $status = new Status();
            $status->setId($fila['id']);
            $status->setNombre($fila['nombre']);
            $status->setDescripcion($fila['descripcion']);
        }

        return $status;
    }
}
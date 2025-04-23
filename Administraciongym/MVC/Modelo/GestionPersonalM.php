<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/GestionPersonal.php';

class GestionPersonalM {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar() {
        $listaPersonal = array();
        $sql = "SELECT id, nombre, puesto, fecha_ingreso, correo, telefono, estado 
                FROM gestionpersonal ORDER BY nombre;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $personal = new GestionPersonal();
                $personal->setId($fila['id']);
                $personal->setNombre($fila['nombre']);
                $personal->setPuesto($fila['puesto']);
                $personal->setFechaIngreso($fila['fecha_ingreso']);
                $personal->setCorreo($fila['correo']);
                $personal->setTelefono($fila['telefono']);
                $personal->setEstado($fila['estado']);
                $listaPersonal[] = $personal;
            }
        }

        $this->conexion->Cerrar();
        return $listaPersonal;
    }

    public function obtenerPorId($id) {
        $personal = null;
        $id = (int)$id; // Asegurar que es un entero
        $sql = "SELECT id, nombre, puesto, fecha_ingreso, correo, telefono, estado 
                FROM gestionpersonal WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $personal = new GestionPersonal();
            $personal->setId($fila['id']);
            $personal->setNombre($fila['nombre']);
            $personal->setPuesto($fila['puesto']);
            $personal->setFechaIngreso($fila['fecha_ingreso']);
            $personal->setCorreo($fila['correo']);
            $personal->setTelefono($fila['telefono']);
            $personal->setEstado($fila['estado']);
        }

        $this->conexion->Cerrar();
        return $personal;
    }

    public function insertar(GestionPersonal $personal) {
        $nombre = $this->conexion->mysqli->real_escape_string($personal->getNombre());
        $puesto = $this->conexion->mysqli->real_escape_string($personal->getPuesto());
        $fechaIngreso = $this->conexion->mysqli->real_escape_string($personal->getFechaIngreso());
        $correo = $this->conexion->mysqli->real_escape_string($personal->getCorreo());
        $telefono = $this->conexion->mysqli->real_escape_string($personal->getTelefono());
        $estado = $this->conexion->mysqli->real_escape_string($personal->getEstado());

        $sql = "INSERT INTO gestionpersonal (nombre, puesto, fecha_ingreso, correo, telefono, estado) 
                VALUES ('$nombre', '$puesto', '$fechaIngreso', '$correo', '$telefono', '$estado');";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $this->conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $personal->setId($id);
        }

        $this->conexion->Cerrar();
        return $resultado;
    }

    public function actualizar(GestionPersonal $personal) {
        $id = (int)$personal->getId(); // Asegurar que es un entero
        $nombre = $this->conexion->mysqli->real_escape_string($personal->getNombre());
        $puesto = $this->conexion->mysqli->real_escape_string($personal->getPuesto());
        $fechaIngreso = $this->conexion->mysqli->real_escape_string($personal->getFechaIngreso());
        $correo = $this->conexion->mysqli->real_escape_string($personal->getCorreo());
        $telefono = $this->conexion->mysqli->real_escape_string($personal->getTelefono());
        $estado = $this->conexion->mysqli->real_escape_string($personal->getEstado());

        $sql = "UPDATE gestionpersonal SET
                nombre = '$nombre',
                puesto = '$puesto',
                fecha_ingreso = '$fechaIngreso',
                correo = '$correo',
                telefono = '$telefono',
                estado = '$estado'
                WHERE id = $id;";

        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    public function eliminar($id) {
        $id = (int)$id; // Asegurar que es un entero
        $sql = "DELETE FROM gestionpersonal WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    // Método para buscar personal por nombre
    public function buscarPorNombre($busqueda) {
        $listaPersonal = array();
        $busqueda = $this->conexion->mysqli->real_escape_string($busqueda);

        $sql = "SELECT id, nombre, puesto, fecha_ingreso, correo, telefono, estado 
                FROM gestionpersonal 
                WHERE nombre LIKE '%$busqueda%' OR puesto LIKE '%$busqueda%'
                ORDER BY nombre;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $personal = new GestionPersonal();
                $personal->setId($fila['id']);
                $personal->setNombre($fila['nombre']);
                $personal->setPuesto($fila['puesto']);
                $personal->setFechaIngreso($fila['fecha_ingreso']);
                $personal->setCorreo($fila['correo']);
                $personal->setTelefono($fila['telefono']);
                $personal->setEstado($fila['estado']);
                $listaPersonal[] = $personal;
            }
        }

        $this->conexion->Cerrar();
        return $listaPersonal;
    }

    // Método para listar personal por estado (activo/inactivo)
    public function listarPorEstado($estado) {
        $listaPersonal = array();
        $estado = $this->conexion->mysqli->real_escape_string($estado);

        $sql = "SELECT id, nombre, puesto, fecha_ingreso, correo, telefono, estado 
                FROM gestionpersonal 
                WHERE estado = '$estado'
                ORDER BY nombre;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $personal = new GestionPersonal();
                $personal->setId($fila['id']);
                $personal->setNombre($fila['nombre']);
                $personal->setPuesto($fila['puesto']);
                $personal->setFechaIngreso($fila['fecha_ingreso']);
                $personal->setCorreo($fila['correo']);
                $personal->setTelefono($fila['telefono']);
                $personal->setEstado($fila['estado']);
                $listaPersonal[] = $personal;
            }
        }

        $this->conexion->Cerrar();
        return $listaPersonal;
    }
}
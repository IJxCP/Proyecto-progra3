<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/GestionDatos.php';

class GestionDatosM {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function BuscarId($id) {
        $gestionDatos = null;
        $id = (int)$id; // Asegurar que es un entero

        $sql = "SELECT id, idcliente, idstatus, fechaultimaactualizacion, observaciones 
                FROM gestiondedatos WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $gestionDatos = new GestionDatos();
            $gestionDatos->setId($fila['id']);
            $gestionDatos->setIdCliente($fila['idcliente']);
            $gestionDatos->setIdStatus($fila['idstatus']);
            $gestionDatos->setFechaUltimaActualizacion($fila['fechaultimaactualizacion']);
            $gestionDatos->setObservaciones($fila['observaciones']);
        }

        $this->conexion->Cerrar();
        return $gestionDatos;
    }

    public function BuscarTodos() {
        $listaGestionDatos = array();

        $sql = "SELECT gd.id, gd.idcliente, gd.idstatus, gd.fechaultimaactualizacion, gd.observaciones,
                s.nombre as nombre_status, dp.nombre, dp.apellido1, dp.apellido2
                FROM gestiondedatos gd
                INNER JOIN status s ON gd.idstatus = s.id
                INNER JOIN registrocliente rc ON gd.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                ORDER BY gd.fechaultimaactualizacion DESC;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionDatos = new GestionDatos();
                $gestionDatos->setId($fila['id']);
                $gestionDatos->setIdCliente($fila['idcliente']);
                $gestionDatos->setIdStatus($fila['idstatus']);
                $gestionDatos->setFechaUltimaActualizacion($fila['fechaultimaactualizacion']);
                $gestionDatos->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $gestionDatos->setDatosAdicionales([
                    'nombre_status' => $fila['nombre_status'],
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaGestionDatos[] = $gestionDatos;
            }
        }

        $this->conexion->Cerrar();
        return $listaGestionDatos;
    }

    public function Insertar(GestionDatos $gestionDatos) {
        $idCliente = (int)$gestionDatos->getIdCliente();
        $idStatus = (int)$gestionDatos->getIdStatus();
        $fechaUltimaActualizacion = $this->conexion->mysqli->real_escape_string($gestionDatos->getFechaUltimaActualizacion());
        $observaciones = $this->conexion->mysqli->real_escape_string($gestionDatos->getObservaciones());

        $sql = "INSERT INTO gestiondedatos (idcliente, idstatus, fechaultimaactualizacion, observaciones) 
                VALUES ($idCliente, $idStatus, '$fechaUltimaActualizacion', '$observaciones');";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $this->conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $gestionDatos->setId($id);
        }

        $this->conexion->Cerrar();
        return $resultado;
    }

    public function Actualizar(GestionDatos $gestionDatos) {
        $id = (int)$gestionDatos->getId();
        $idCliente = (int)$gestionDatos->getIdCliente();
        $idStatus = (int)$gestionDatos->getIdStatus();
        $fechaUltimaActualizacion = $this->conexion->mysqli->real_escape_string($gestionDatos->getFechaUltimaActualizacion());
        $observaciones = $this->conexion->mysqli->real_escape_string($gestionDatos->getObservaciones());

        $sql = "UPDATE gestiondedatos SET
                idcliente = $idCliente,
                idstatus = $idStatus,
                fechaultimaactualizacion = '$fechaUltimaActualizacion',
                observaciones = '$observaciones'
                WHERE id = $id;";

        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    public function Eliminar($id) {
        $id = (int)$id; // Asegurar que es un entero
        $sql = "DELETE FROM gestiondedatos WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    // Método para obtener todos los datos de gestión con información de cliente y status
    public function BuscarGestionConClienteYStatus($id) {
        require_once 'MVC/Modelo/RegistroClienteM.php';
        require_once 'MVC/Modelo/StatusM.php';

        $gestionDatos = $this->BuscarId($id);

        if ($gestionDatos) {
            $registroClienteM = new RegistroClienteM();
            $statusM = new StatusM();

            $cliente = $registroClienteM->BuscarClienteCompleto($gestionDatos->getIdCliente());
            $status = $statusM->BuscarId($gestionDatos->getIdStatus());

            // Crear un array asociativo con toda la información
            $gestionCompleta = array(
                'gestionDatos' => $gestionDatos,
                'cliente' => $cliente,
                'status' => $status
            );

            return $gestionCompleta;
        }

        return null;
    }

    // Método para buscar gestiones por status
    public function BuscarPorStatus($idStatus) {
        $listaGestionDatos = array();
        $idStatus = (int)$idStatus;

        $sql = "SELECT gd.id, gd.idcliente, gd.idstatus, gd.fechaultimaactualizacion, gd.observaciones,
                s.nombre as nombre_status, dp.nombre, dp.apellido1, dp.apellido2
                FROM gestiondedatos gd
                INNER JOIN status s ON gd.idstatus = s.id
                INNER JOIN registrocliente rc ON gd.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                WHERE gd.idstatus = $idStatus
                ORDER BY gd.fechaultimaactualizacion DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionDatos = new GestionDatos();
                $gestionDatos->setId($fila['id']);
                $gestionDatos->setIdCliente($fila['idcliente']);
                $gestionDatos->setIdStatus($fila['idstatus']);
                $gestionDatos->setFechaUltimaActualizacion($fila['fechaultimaactualizacion']);
                $gestionDatos->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $gestionDatos->setDatosAdicionales([
                    'nombre_status' => $fila['nombre_status'],
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaGestionDatos[] = $gestionDatos;
            }
        }

        $this->conexion->Cerrar();
        return $listaGestionDatos;
    }

    // Método para buscar gestiones por cliente
    public function BuscarPorCliente($idCliente) {
        $listaGestionDatos = array();
        $idCliente = (int)$idCliente;

        $sql = "SELECT gd.id, gd.idcliente, gd.idstatus, gd.fechaultimaactualizacion, gd.observaciones,
                s.nombre as nombre_status
                FROM gestiondedatos gd
                INNER JOIN status s ON gd.idstatus = s.id
                WHERE gd.idcliente = $idCliente
                ORDER BY gd.fechaultimaactualizacion DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionDatos = new GestionDatos();
                $gestionDatos->setId($fila['id']);
                $gestionDatos->setIdCliente($fila['idcliente']);
                $gestionDatos->setIdStatus($fila['idstatus']);
                $gestionDatos->setFechaUltimaActualizacion($fila['fechaultimaactualizacion']);
                $gestionDatos->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $gestionDatos->setDatosAdicionales([
                    'nombre_status' => $fila['nombre_status']
                ]);

                $listaGestionDatos[] = $gestionDatos;
            }
        }

        $this->conexion->Cerrar();
        return $listaGestionDatos;
    }

    // Método para buscar gestiones por nombre de cliente
    public function BuscarPorNombreCliente($busqueda) {
        $listaGestionDatos = array();
        $busqueda = $this->conexion->mysqli->real_escape_string($busqueda);

        $sql = "SELECT gd.id, gd.idcliente, gd.idstatus, gd.fechaultimaactualizacion, gd.observaciones,
                s.nombre as nombre_status, dp.nombre, dp.apellido1, dp.apellido2
                FROM gestiondedatos gd
                INNER JOIN status s ON gd.idstatus = s.id
                INNER JOIN registrocliente rc ON gd.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                WHERE dp.nombre LIKE '%$busqueda%' OR dp.apellido1 LIKE '%$busqueda%' OR dp.apellido2 LIKE '%$busqueda%'
                ORDER BY gd.fechaultimaactualizacion DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionDatos = new GestionDatos();
                $gestionDatos->setId($fila['id']);
                $gestionDatos->setIdCliente($fila['idcliente']);
                $gestionDatos->setIdStatus($fila['idstatus']);
                $gestionDatos->setFechaUltimaActualizacion($fila['fechaultimaactualizacion']);
                $gestionDatos->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $gestionDatos->setDatosAdicionales([
                    'nombre_status' => $fila['nombre_status'],
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaGestionDatos[] = $gestionDatos;
            }
        }

        $this->conexion->Cerrar();
        return $listaGestionDatos;
    }
}
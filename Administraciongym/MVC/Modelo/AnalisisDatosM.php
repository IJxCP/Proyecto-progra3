<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/AnalisisDatos.php';

class AnalisisDatosM {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar() {
        $listaAnalisis = array();
        $sql = "SELECT a.id, a.idcliente, a.fecha, a.tipo_analisis, a.resultado, a.observaciones,
                rc.iddatospersonales, dp.nombre, dp.apellido1, dp.apellido2
                FROM analisisdatos a
                INNER JOIN registrocliente rc ON a.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                ORDER BY a.fecha DESC;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $analisis = new AnalisisDatos();
                $analisis->setId($fila['id']);
                $analisis->setIdcliente($fila['idcliente']);
                $analisis->setFecha($fila['fecha']);
                $analisis->setTipoAnalisis($fila['tipo_analisis']);
                $analisis->setResultado($fila['resultado']);
                $analisis->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $analisis->setDatosAdicionales([
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaAnalisis[] = $analisis;
            }
        }

        $this->conexion->Cerrar();
        return $listaAnalisis;
    }

    public function obtenerPorId($id) {
        $analisis = null;
        $id = (int)$id; // Asegurar que es un entero
        $sql = "SELECT id, idcliente, fecha, tipo_analisis, resultado, observaciones 
                FROM analisisdatos WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $analisis = new AnalisisDatos();
            $analisis->setId($fila['id']);
            $analisis->setIdcliente($fila['idcliente']);
            $analisis->setFecha($fila['fecha']);
            $analisis->setTipoAnalisis($fila['tipo_analisis']);
            $analisis->setResultado($fila['resultado']);
            $analisis->setObservaciones($fila['observaciones']);
        }

        $this->conexion->Cerrar();
        return $analisis;
    }

    public function insertar(AnalisisDatos $analisis) {
        $idcliente = (int)$analisis->getIdcliente();
        $fecha = $this->conexion->mysqli->real_escape_string($analisis->getFecha());
        $tipoAnalisis = $this->conexion->mysqli->real_escape_string($analisis->getTipoAnalisis());
        $resultado = $this->conexion->mysqli->real_escape_string($analisis->getResultado());
        $observaciones = $this->conexion->mysqli->real_escape_string($analisis->getObservaciones());

        $sql = "INSERT INTO analisisdatos (idcliente, fecha, tipo_analisis, resultado, observaciones) 
                VALUES ($idcliente, '$fecha', '$tipoAnalisis', '$resultado', '$observaciones');";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $this->conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $analisis->setId($id);
        }

        $this->conexion->Cerrar();
        return $resultado;
    }

    public function actualizar(AnalisisDatos $analisis) {
        $id = (int)$analisis->getId();
        $idcliente = (int)$analisis->getIdcliente();
        $fecha = $this->conexion->mysqli->real_escape_string($analisis->getFecha());
        $tipoAnalisis = $this->conexion->mysqli->real_escape_string($analisis->getTipoAnalisis());
        $resultado = $this->conexion->mysqli->real_escape_string($analisis->getResultado());
        $observaciones = $this->conexion->mysqli->real_escape_string($analisis->getObservaciones());

        $sql = "UPDATE analisisdatos SET
                idcliente = $idcliente,
                fecha = '$fecha',
                tipo_analisis = '$tipoAnalisis',
                resultado = '$resultado',
                observaciones = '$observaciones'
                WHERE id = $id;";

        $result = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $result;
    }

    public function eliminar($id) {
        $id = (int)$id; // Asegurar que es un entero
        $sql = "DELETE FROM analisisdatos WHERE id = $id;";
        $resultado = $this->conexion->Ejecutar($sql);
        $this->conexion->Cerrar();
        return $resultado;
    }

    // Obtener análisis por cliente
    public function obtenerPorCliente($idCliente) {
        $listaAnalisis = array();
        $idCliente = (int)$idCliente;

        $sql = "SELECT a.id, a.idcliente, a.fecha, a.tipo_analisis, a.resultado, a.observaciones,
                rc.iddatospersonales, dp.nombre, dp.apellido1, dp.apellido2
                FROM analisisdatos a
                INNER JOIN registrocliente rc ON a.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                WHERE a.idcliente = $idCliente
                ORDER BY a.fecha DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $analisis = new AnalisisDatos();
                $analisis->setId($fila['id']);
                $analisis->setIdcliente($fila['idcliente']);
                $analisis->setFecha($fila['fecha']);
                $analisis->setTipoAnalisis($fila['tipo_analisis']);
                $analisis->setResultado($fila['resultado']);
                $analisis->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $analisis->setDatosAdicionales([
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaAnalisis[] = $analisis;
            }
        }

        $this->conexion->Cerrar();
        return $listaAnalisis;
    }

    // Obtener análisis por tipo
    public function obtenerPorTipo($tipoAnalisis) {
        $listaAnalisis = array();
        $tipoAnalisis = $this->conexion->mysqli->real_escape_string($tipoAnalisis);

        $sql = "SELECT a.id, a.idcliente, a.fecha, a.tipo_analisis, a.resultado, a.observaciones,
                rc.iddatospersonales, dp.nombre, dp.apellido1, dp.apellido2
                FROM analisisdatos a
                INNER JOIN registrocliente rc ON a.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                WHERE a.tipo_analisis = '$tipoAnalisis'
                ORDER BY a.fecha DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $analisis = new AnalisisDatos();
                $analisis->setId($fila['id']);
                $analisis->setIdcliente($fila['idcliente']);
                $analisis->setFecha($fila['fecha']);
                $analisis->setTipoAnalisis($fila['tipo_analisis']);
                $analisis->setResultado($fila['resultado']);
                $analisis->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $analisis->setDatosAdicionales([
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaAnalisis[] = $analisis;
            }
        }

        $this->conexion->Cerrar();
        return $listaAnalisis;
    }

    // Buscar análisis por texto en resultado u observaciones
    public function buscarPorTexto($busqueda) {
        $listaAnalisis = array();
        $busqueda = $this->conexion->mysqli->real_escape_string($busqueda);

        $sql = "SELECT a.id, a.idcliente, a.fecha, a.tipo_analisis, a.resultado, a.observaciones,
                rc.iddatospersonales, dp.nombre, dp.apellido1, dp.apellido2
                FROM analisisdatos a
                INNER JOIN registrocliente rc ON a.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                WHERE a.resultado LIKE '%$busqueda%' 
                   OR a.observaciones LIKE '%$busqueda%'
                   OR a.tipo_analisis LIKE '%$busqueda%'
                   OR dp.nombre LIKE '%$busqueda%'
                   OR dp.apellido1 LIKE '%$busqueda%'
                ORDER BY a.fecha DESC;";

        $resultado = $this->conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $analisis = new AnalisisDatos();
                $analisis->setId($fila['id']);
                $analisis->setIdcliente($fila['idcliente']);
                $analisis->setFecha($fila['fecha']);
                $analisis->setTipoAnalisis($fila['tipo_analisis']);
                $analisis->setResultado($fila['resultado']);
                $analisis->setObservaciones($fila['observaciones']);

                // Añadir datos adicionales para mostrar en la lista
                $analisis->setDatosAdicionales([
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaAnalisis[] = $analisis;
            }
        }

        $this->conexion->Cerrar();
        return $listaAnalisis;
    }

    // Obtener análisis completo con datos del cliente
    public function obtenerAnalisisCompleto($id) {
        require_once 'MVC/Modelo/RegistroClienteM.php';

        $analisis = $this->obtenerPorId($id);

        if ($analisis) {
            $registroClienteM = new RegistroClienteM();
            $cliente = $registroClienteM->BuscarClienteCompleto($analisis->getIdcliente());

            if ($cliente) {
                $analisisCompleto = array(
                    'analisis' => $analisis,
                    'cliente' => $cliente
                );

                return $analisisCompleto;
            }
        }

        return null;
    }
}
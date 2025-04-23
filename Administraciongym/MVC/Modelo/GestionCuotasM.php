<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/GestionCuotas.php';

class GestionCuotasM {
    public function BuscarId($id) {
        $gestionCuotas = new GestionCuotas();
        $conexion = new Conexion();
        $sql = "SELECT id, idinscripcion, fechapago, monto, metodopago, comprobante, estado, observaciones 
                FROM gestiondecuotas WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $gestionCuotas->setId($fila['id']);
            $gestionCuotas->setIdInscripcion($fila['idinscripcion']);
            $gestionCuotas->setFechaPago($fila['fechapago']);
            $gestionCuotas->setMonto($fila['monto']);
            $gestionCuotas->setMetodoPago($fila['metodopago']);
            $gestionCuotas->setComprobante($fila['comprobante']);
            $gestionCuotas->setEstado($fila['estado']);
            $gestionCuotas->setObservaciones($fila['observaciones']);
        } else {
            $gestionCuotas = null;
        }

        $conexion->Cerrar();
        return $gestionCuotas;
    }

    public function BuscarTodos() {
        $listaGestionCuotas = array();
        $conexion = new Conexion();
        $sql = "SELECT id, idinscripcion, fechapago, monto, metodopago, comprobante, estado, observaciones 
                FROM gestiondecuotas ORDER BY fechapago DESC;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionCuotas = new GestionCuotas();
                $gestionCuotas->setId($fila['id']);
                $gestionCuotas->setIdInscripcion($fila['idinscripcion']);
                $gestionCuotas->setFechaPago($fila['fechapago']);
                $gestionCuotas->setMonto($fila['monto']);
                $gestionCuotas->setMetodoPago($fila['metodopago']);
                $gestionCuotas->setComprobante($fila['comprobante']);
                $gestionCuotas->setEstado($fila['estado']);
                $gestionCuotas->setObservaciones($fila['observaciones']);
                $listaGestionCuotas[] = $gestionCuotas;
            }
        }

        $conexion->Cerrar();
        return $listaGestionCuotas;
    }

    public function Insertar(GestionCuotas $gestionCuotas) {
        $conexion = new Conexion();
        $sql = "INSERT INTO gestiondecuotas (idinscripcion, fechapago, monto, metodopago, comprobante, estado, observaciones) 
                VALUES (" . $gestionCuotas->getIdInscripcion() . ", 
                '" . $gestionCuotas->getFechaPago() . "', 
                " . $gestionCuotas->getMonto() . ", 
                '" . $gestionCuotas->getMetodoPago() . "', 
                '" . $gestionCuotas->getComprobante() . "', 
                '" . $gestionCuotas->getEstado() . "', 
                '" . $gestionCuotas->getObservaciones() . "');";

        $resultado = $conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $gestionCuotas->setId($id);
        }

        $conexion->Cerrar();
        return $resultado;
    }

    public function Actualizar(GestionCuotas $gestionCuotas) {
        $conexion = new Conexion();
        $sql = "UPDATE gestiondecuotas SET
                idinscripcion = " . $gestionCuotas->getIdInscripcion() . ",
                fechapago = '" . $gestionCuotas->getFechaPago() . "',
                monto = " . $gestionCuotas->getMonto() . ",
                metodopago = '" . $gestionCuotas->getMetodoPago() . "',
                comprobante = '" . $gestionCuotas->getComprobante() . "',
                estado = '" . $gestionCuotas->getEstado() . "',
                observaciones = '" . $gestionCuotas->getObservaciones() . "'
                WHERE id = " . $gestionCuotas->getId() . ";";

        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    public function Eliminar($id) {
        $conexion = new Conexion();
        $sql = "DELETE FROM gestiondecuotas WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    // Buscar cuotas por inscripción
    public function BuscarPorInscripcion($idInscripcion) {
        $listaGestionCuotas = array();
        $conexion = new Conexion();
        $sql = "SELECT id, idinscripcion, fechapago, monto, metodopago, comprobante, estado, observaciones 
                FROM gestiondecuotas WHERE idinscripcion = $idInscripcion ORDER BY fechapago DESC;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionCuotas = new GestionCuotas();
                $gestionCuotas->setId($fila['id']);
                $gestionCuotas->setIdInscripcion($fila['idinscripcion']);
                $gestionCuotas->setFechaPago($fila['fechapago']);
                $gestionCuotas->setMonto($fila['monto']);
                $gestionCuotas->setMetodoPago($fila['metodopago']);
                $gestionCuotas->setComprobante($fila['comprobante']);
                $gestionCuotas->setEstado($fila['estado']);
                $gestionCuotas->setObservaciones($fila['observaciones']);
                $listaGestionCuotas[] = $gestionCuotas;
            }
        }

        $conexion->Cerrar();
        return $listaGestionCuotas;
    }

    // Buscar cuotas por estado
    public function BuscarPorEstado($estado) {
        $listaGestionCuotas = array();
        $conexion = new Conexion();
        $estado = $conexion->mysqli->real_escape_string($estado);
        $sql = "SELECT id, idinscripcion, fechapago, monto, metodopago, comprobante, estado, observaciones 
                FROM gestiondecuotas WHERE estado = '$estado' ORDER BY fechapago DESC;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionCuotas = new GestionCuotas();
                $gestionCuotas->setId($fila['id']);
                $gestionCuotas->setIdInscripcion($fila['idinscripcion']);
                $gestionCuotas->setFechaPago($fila['fechapago']);
                $gestionCuotas->setMonto($fila['monto']);
                $gestionCuotas->setMetodoPago($fila['metodopago']);
                $gestionCuotas->setComprobante($fila['comprobante']);
                $gestionCuotas->setEstado($fila['estado']);
                $gestionCuotas->setObservaciones($fila['observaciones']);
                $listaGestionCuotas[] = $gestionCuotas;
            }
        }

        $conexion->Cerrar();
        return $listaGestionCuotas;
    }

    // Buscar cuotas por fecha de pago
    public function BuscarPorFechaPago($fechaInicio, $fechaFin) {
        $listaGestionCuotas = array();
        $conexion = new Conexion();
        $fechaInicio = $conexion->mysqli->real_escape_string($fechaInicio);
        $fechaFin = $conexion->mysqli->real_escape_string($fechaFin);
        $sql = "SELECT id, idinscripcion, fechapago, monto, metodopago, comprobante, estado, observaciones 
                FROM gestiondecuotas 
                WHERE fechapago BETWEEN '$fechaInicio' AND '$fechaFin' 
                ORDER BY fechapago;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $gestionCuotas = new GestionCuotas();
                $gestionCuotas->setId($fila['id']);
                $gestionCuotas->setIdInscripcion($fila['idinscripcion']);
                $gestionCuotas->setFechaPago($fila['fechapago']);
                $gestionCuotas->setMonto($fila['monto']);
                $gestionCuotas->setMetodoPago($fila['metodopago']);
                $gestionCuotas->setComprobante($fila['comprobante']);
                $gestionCuotas->setEstado($fila['estado']);
                $gestionCuotas->setObservaciones($fila['observaciones']);
                $listaGestionCuotas[] = $gestionCuotas;
            }
        }

        $conexion->Cerrar();
        return $listaGestionCuotas;
    }
}
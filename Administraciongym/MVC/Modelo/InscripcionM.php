<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/Inscripciones.php';

class InscripcionM {
    public function BuscarId($id) {
        $inscripcion = new Inscripcion();
        $conexion = new Conexion();
        $sql = "SELECT id, idgestiondatos, fechainscripcion, fechavencimiento, tipomembresia, monto 
                FROM inscripcion WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $inscripcion->setId($fila['id']);
            $inscripcion->setIdGestionDatos($fila['idgestiondatos']);
            $inscripcion->setFechaInscripcion($fila['fechainscripcion']);
            $inscripcion->setFechaVencimiento($fila['fechavencimiento']);
            $inscripcion->setTipoMembresia($fila['tipomembresia']);
            $inscripcion->setMonto($fila['monto']);
        } else {
            $inscripcion = null;
        }

        $conexion->Cerrar();
        return $inscripcion;
    }

    public function BuscarTodos() {
        $listaInscripciones = array();
        $conexion = new Conexion();
        $sql = "SELECT i.id, i.idgestiondatos, i.fechainscripcion, i.fechavencimiento, i.tipomembresia, i.monto,
                gd.idcliente, rc.iddatospersonales, dp.nombre, dp.apellido1, dp.apellido2
                FROM inscripcion i
                INNER JOIN gestiondedatos gd ON i.idgestiondatos = gd.id
                INNER JOIN registrocliente rc ON gd.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                ORDER BY i.fechainscripcion DESC;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $inscripcion = new Inscripcion();
                $inscripcion->setId($fila['id']);
                $inscripcion->setIdGestionDatos($fila['idgestiondatos']);
                $inscripcion->setFechaInscripcion($fila['fechainscripcion']);
                $inscripcion->setFechaVencimiento($fila['fechavencimiento']);
                $inscripcion->setTipoMembresia($fila['tipomembresia']);
                $inscripcion->setMonto($fila['monto']);

                // Añadir datos adicionales para mostrar en la lista
                $inscripcion->setDatosAdicionales([
                    'idcliente' => $fila['idcliente'],
                    'iddatospersonales' => $fila['iddatospersonales'],
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaInscripciones[] = $inscripcion;
            }
        }

        $conexion->Cerrar();
        return $listaInscripciones;
    }

    public function Insertar(Inscripcion $inscripcion) {
        $conexion = new Conexion();
        $sql = "INSERT INTO inscripcion (idgestiondatos, fechainscripcion, fechavencimiento, tipomembresia, monto) 
                VALUES (" . $inscripcion->getIdGestionDatos() . ", 
                '" . $inscripcion->getFechaInscripcion() . "', 
                '" . $inscripcion->getFechaVencimiento() . "', 
                '" . $inscripcion->getTipoMembresia() . "', 
                " . $inscripcion->getMonto() . ");";

        $resultado = $conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $inscripcion->setId($id);
        }

        $conexion->Cerrar();
        return $resultado;
    }

    public function Actualizar(Inscripcion $inscripcion) {
        $conexion = new Conexion();
        $sql = "UPDATE inscripcion SET
                idgestiondatos = " . $inscripcion->getIdGestionDatos() . ",
                fechainscripcion = '" . $inscripcion->getFechaInscripcion() . "',
                fechavencimiento = '" . $inscripcion->getFechaVencimiento() . "',
                tipomembresia = '" . $inscripcion->getTipoMembresia() . "',
                monto = " . $inscripcion->getMonto() . "
                WHERE id = " . $inscripcion->getId() . ";";

        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    public function Eliminar($id) {
        $conexion = new Conexion();
        $sql = "DELETE FROM inscripcion WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    // Obtener inscripciones por cliente
    public function BuscarPorCliente($idCliente) {
        require_once 'MVC/Modelo/GestionDatosM.php';

        $gestionDatosM = new GestionDatosM();
        $gestionesDatos = $gestionDatosM->BuscarPorCliente($idCliente);

        $listaInscripciones = array();

        if ($gestionesDatos) {
            $conexion = new Conexion();

            foreach ($gestionesDatos as $gestion) {
                $sql = "SELECT id, idgestiondatos, fechainscripcion, fechavencimiento, tipomembresia, monto 
                        FROM inscripcion WHERE idgestiondatos = " . $gestion->getId() . "
                        ORDER BY fechainscripcion DESC;";
                $resultado = $conexion->Ejecutar($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        $inscripcion = new Inscripcion();
                        $inscripcion->setId($fila['id']);
                        $inscripcion->setIdGestionDatos($fila['idgestiondatos']);
                        $inscripcion->setFechaInscripcion($fila['fechainscripcion']);
                        $inscripcion->setFechaVencimiento($fila['fechavencimiento']);
                        $inscripcion->setTipoMembresia($fila['tipomembresia']);
                        $inscripcion->setMonto($fila['monto']);
                        $listaInscripciones[] = $inscripcion;
                    }
                }
            }

            $conexion->Cerrar();
        }

        return (!empty($listaInscripciones)) ? $listaInscripciones : null;
    }

    // Método para obtener inscripciones por vencer en los próximos X días
    public function BuscarInscripcionesPorVencer($dias) {
        $listaInscripciones = array();
        $conexion = new Conexion();
        $sql = "SELECT i.id, i.idgestiondatos, i.fechainscripcion, i.fechavencimiento, i.tipomembresia, i.monto,
                gd.idcliente, rc.iddatospersonales, dp.nombre, dp.apellido1, dp.apellido2
                FROM inscripcion i
                INNER JOIN gestiondedatos gd ON i.idgestiondatos = gd.id
                INNER JOIN registrocliente rc ON gd.idcliente = rc.id
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                WHERE i.fechavencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL $dias DAY)
                ORDER BY i.fechavencimiento;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $inscripcion = new Inscripcion();
                $inscripcion->setId($fila['id']);
                $inscripcion->setIdGestionDatos($fila['idgestiondatos']);
                $inscripcion->setFechaInscripcion($fila['fechainscripcion']);
                $inscripcion->setFechaVencimiento($fila['fechavencimiento']);
                $inscripcion->setTipoMembresia($fila['tipomembresia']);
                $inscripcion->setMonto($fila['monto']);

                // Añadir datos adicionales para mostrar en la lista
                $inscripcion->setDatosAdicionales([
                    'idcliente' => $fila['idcliente'],
                    'iddatospersonales' => $fila['iddatospersonales'],
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaInscripciones[] = $inscripcion;
            }
        }

        $conexion->Cerrar();
        return $listaInscripciones;
    }

    // Obtener inscripción completa con datos del cliente
    public function BuscarInscripcionCompleta($id) {
        require_once 'MVC/Modelo/GestionDatosM.php';

        $inscripcion = $this->BuscarId($id);

        if ($inscripcion) {
            $gestionDatosM = new GestionDatosM();
            $gestionCompleta = $gestionDatosM->BuscarGestionConClienteYStatus($inscripcion->getIdGestionDatos());

            if ($gestionCompleta) {
                $inscripcionCompleta = array(
                    'inscripcion' => $inscripcion,
                    'gestionDatos' => $gestionCompleta
                );

                return $inscripcionCompleta;
            }
        }

        return null;
    }

    // Método para agregar soporte de datos adicionales a la clase Inscripcion
    private function setDatosAdicionales(Inscripcion $inscripcion, $datos) {
        if (method_exists($inscripcion, 'setDatosAdicionales')) {
            $inscripcion->setDatosAdicionales($datos);
        }
    }
}
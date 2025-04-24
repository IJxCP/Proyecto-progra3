<?php
require_once(__DIR__ . '/../../Conexion.php');
require_once('C:/xampp/htdocs/Administraciongym/MVC/Entidades/DatosPersonales.php');

class DatosPersonalesM {
    public function BuscarId($id) {
        $datosPersonales = new DatosPersonales();
        $conexion = new Conexion();
        $sql = "SELECT ID, NOMBRE, APELLIDO1, APELLIDO2, fechanacimiento, TELEFONO, CORREO, DIRECCION 
                FROM datospersonales WHERE ID = $id;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $fila = $resultado->fetch_assoc();
            $datosPersonales->setId($fila['ID']);
            $datosPersonales->setNombre($fila['NOMBRE']);
            $datosPersonales->setApellido1($fila['APELLIDO1']);
            $datosPersonales->setApellido2($fila['APELLIDO2']);
            $datosPersonales->setFechaNacimiento($fila['FECHA_NACIMIENTO']);
            $datosPersonales->setTelefono($fila['TELEFONO']);
            $datosPersonales->setCorreo($fila['CORREO']);
            $datosPersonales->setDireccion($fila['DIRECCION']);
        } else {
            $datosPersonales = null;
        }

        $conexion->Cerrar();
        return $datosPersonales;
    }

    public function BuscarTodos() {
        $listaDatosPersonales = array();
        $conexion = new Conexion();
        $sql = "SELECT ID, NOMBRE, APELLIDO1, APELLIDO2, fechanacimiento, TELEFONO, CORREO, DIRECCION 
                FROM datospersonales;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $datosPersonales = new DatosPersonales();
                $datosPersonales->setId($fila['ID']);
                $datosPersonales->setNombre($fila['NOMBRE']);
                $datosPersonales->setApellido1($fila['APELLIDO1']);
                $datosPersonales->setApellido2($fila['APELLIDO2']);
                $datosPersonales->setFechaNacimiento($fila['FECHA_NACIMIENTO']);
                $datosPersonales->setTelefono($fila['TELEFONO']);
                $datosPersonales->setCorreo($fila['CORREO']);
                $datosPersonales->setDireccion($fila['DIRECCION']);
                $listaDatosPersonales[] = $datosPersonales;
            }
        } else {
            $listaDatosPersonales = null;
        }

        $conexion->Cerrar();
        return $listaDatosPersonales;
    }

    public function Insertar(DatosPersonales $datosPersonales) {
        $conexion = new Conexion();
        $sql = "INSERT INTO datospersonales (NOMBRE, APELLIDO1, APELLIDO2, fechanacimiento, TELEFONO, CORREO, DIRECCION) 
                VALUES ('" . $datosPersonales->getNombre() . "', 
                '" . $datosPersonales->getApellido1() . "', 
                '" . $datosPersonales->getApellido2() . "', 
                '" . $datosPersonales->getFechaNacimiento() . "', 
                '" . $datosPersonales->getTelefono() . "', 
                '" . $datosPersonales->getCorreo() . "', 
                '" . $datosPersonales->getDireccion() . "');";

        $resultado = $conexion->Ejecutar($sql);

        if ($resultado) {
            $idInsertado = $conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $datosPersonales->setId($id);
        }

        $conexion->Cerrar();
        return $resultado;
    }

    public function Actualizar(DatosPersonales $datosPersonales) {
        $conexion = new Conexion();
        $sql = "UPDATE datospersonales SET
                NOMBRE = '" . $datosPersonales->getNombre() . "',
                APELLIDO1 = '" . $datosPersonales->getApellido1() . "',
                APELLIDO2 = '" . $datosPersonales->getApellido2() . "',
                FECHA_NACIMIENTO = '" . $datosPersonales->getFechaNacimiento() . "',
                TELEFONO = '" . $datosPersonales->getTelefono() . "',
                CORREO = '" . $datosPersonales->getCorreo() . "',
                DIRECCION = '" . $datosPersonales->getDireccion() . "'
                WHERE ID = " . $datosPersonales->getId() . ";";

        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    public function Eliminar($id) {
        $conexion = new Conexion();
        $sql = "DELETE FROM datospersonales WHERE ID = $id;";
        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }
}

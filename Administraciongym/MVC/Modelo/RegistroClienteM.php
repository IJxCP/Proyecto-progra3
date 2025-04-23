<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/RegistroCliente.php';

class RegistroClienteM {
    public function BuscarId($id) {
        $registroCliente = new RegistroCliente();
        $conexion = new Conexion();
        $sql = "SELECT id, iddatospersonales, idmaterialmedico, fecharegistro, objetivos, notas 
                FROM registrocliente WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $registroCliente->setId($fila['id']);
            $registroCliente->setIdDatosPersonales($fila['iddatospersonales']);
            $registroCliente->setIdMaterialMedico($fila['idmaterialmedico']);
            $registroCliente->setFechaRegistro($fila['fecharegistro']);
            $registroCliente->setObjetivos($fila['objetivos']);
            $registroCliente->setNotas($fila['notas']);
        } else {
            $registroCliente = null;
        }

        $conexion->Cerrar();
        return $registroCliente;
    }

    public function BuscarTodos() {
        $listaRegistroClientes = array();
        $conexion = new Conexion();
        $sql = "SELECT rc.id, rc.iddatospersonales, rc.idmaterialmedico, rc.fecharegistro, rc.objetivos, rc.notas,
                dp.nombre, dp.apellido1, dp.apellido2, dp.telefono, dp.correo
                FROM registrocliente rc
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                ORDER BY dp.nombre, dp.apellido1;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $registroCliente = new RegistroCliente();
                $registroCliente->setId($fila['id']);
                $registroCliente->setIdDatosPersonales($fila['iddatospersonales']);
                $registroCliente->setIdMaterialMedico($fila['idmaterialmedico']);
                $registroCliente->setFechaRegistro($fila['fecharegistro']);
                $registroCliente->setObjetivos($fila['objetivos']);
                $registroCliente->setNotas($fila['notas']);

                // Agregar datos personales básicos para mostrar en la lista
                $registroCliente->setDatosAdicionales([
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'telefono' => $fila['telefono'],
                    'correo' => $fila['correo'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaRegistroClientes[] = $registroCliente;
            }
        }

        $conexion->Cerrar();
        return $listaRegistroClientes;
    }

    public function Insertar(RegistroCliente $registroCliente) {
        $conexion = new Conexion();
        $sql = "INSERT INTO registrocliente (iddatospersonales, idmaterialmedico, fecharegistro, objetivos, notas) 
                VALUES (" . $registroCliente->getIdDatosPersonales() . ", 
                " . $registroCliente->getIdMaterialMedico() . ", 
                '" . $registroCliente->getFechaRegistro() . "', 
                '" . $registroCliente->getObjetivos() . "', 
                '" . $registroCliente->getNotas() . "');";

        $resultado = $conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $registroCliente->setId($id);
        }

        $conexion->Cerrar();
        return $resultado;
    }

    public function Actualizar(RegistroCliente $registroCliente) {
        $conexion = new Conexion();
        $sql = "UPDATE registrocliente SET
                iddatospersonales = " . $registroCliente->getIdDatosPersonales() . ",
                idmaterialmedico = " . $registroCliente->getIdMaterialMedico() . ",
                fecharegistro = '" . $registroCliente->getFechaRegistro() . "',
                objetivos = '" . $registroCliente->getObjetivos() . "',
                notas = '" . $registroCliente->getNotas() . "'
                WHERE id = " . $registroCliente->getId() . ";";

        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    public function Eliminar($id) {
        $conexion = new Conexion();
        $sql = "DELETE FROM registrocliente WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    // Método para obtener cliente con toda su información relacionada
    public function BuscarClienteCompleto($id) {
        require_once 'MVC/Modelo/DatosPersonalesM.php';
        require_once 'MVC/Modelo/MaterialMedicoM.php';

        $cliente = $this->BuscarId($id);

        if ($cliente) {
            $datosPersonalesM = new DatosPersonalesM();
            $materialMedicoM = new MaterialMedicoM();

            $datosPersonales = $datosPersonalesM->BuscarId($cliente->getIdDatosPersonales());
            $materialMedico = $materialMedicoM->BuscarId($cliente->getIdMaterialMedico());

            // Aquí podríamos crear un array asociativo con toda la información
            $clienteCompleto = array(
                'cliente' => $cliente,
                'datosPersonales' => $datosPersonales,
                'materialMedico' => $materialMedico
            );

            return $clienteCompleto;
        }

        return null;
    }

    // Método para buscar clientes por nombre o apellido
    public function BuscarPorNombre($busqueda) {
        $listaRegistroClientes = array();
        $conexion = new Conexion();
        $busqueda = $conexion->mysqli->real_escape_string($busqueda);

        $sql = "SELECT rc.id, rc.iddatospersonales, rc.idmaterialmedico, rc.fecharegistro, rc.objetivos, rc.notas,
                dp.nombre, dp.apellido1, dp.apellido2, dp.telefono, dp.correo
                FROM registrocliente rc
                INNER JOIN datospersonales dp ON rc.iddatospersonales = dp.id
                WHERE dp.nombre LIKE '%$busqueda%' OR dp.apellido1 LIKE '%$busqueda%' OR dp.apellido2 LIKE '%$busqueda%'
                ORDER BY dp.nombre, dp.apellido1;";

        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $registroCliente = new RegistroCliente();
                $registroCliente->setId($fila['id']);
                $registroCliente->setIdDatosPersonales($fila['iddatospersonales']);
                $registroCliente->setIdMaterialMedico($fila['idmaterialmedico']);
                $registroCliente->setFechaRegistro($fila['fecharegistro']);
                $registroCliente->setObjetivos($fila['objetivos']);
                $registroCliente->setNotas($fila['notas']);

                // Agregar datos personales básicos para mostrar en la lista
                $registroCliente->setDatosAdicionales([
                    'nombre' => $fila['nombre'],
                    'apellido1' => $fila['apellido1'],
                    'apellido2' => $fila['apellido2'],
                    'telefono' => $fila['telefono'],
                    'correo' => $fila['correo'],
                    'nombreCompleto' => $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2']
                ]);

                $listaRegistroClientes[] = $registroCliente;
            }
        }

        $conexion->Cerrar();
        return $listaRegistroClientes;
    }
}
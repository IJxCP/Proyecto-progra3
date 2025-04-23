<?php
require_once 'Conexion.php';
require_once 'MVC/Entidades/MaterialMedico.php';

class MaterialMedicoM {
    public function BuscarId($id) {
        $materialMedico = new MaterialMedico();
        $conexion = new Conexion();
        $sql = "SELECT id, altura, peso, imc, condiciones_medicas, alergias, medicamentos, presion_arterial, frecuencia_cardiaca 
        FROM materialmedico WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $fila = $resultado->fetch_assoc();
            $materialMedico->setId($fila['id']);
            $materialMedico->setAltura($fila['altura']);
            $materialMedico->setPeso($fila['peso']);
            $materialMedico->setImc($fila['imc']);
            $materialMedico->setCondicionesMedicas($fila['condiciones_medicas']);
            $materialMedico->setAlergias($fila['alergias']);
            $materialMedico->setMedicamentos($fila['medicamentos']);
            $materialMedico->setPresionArterial($fila['presion_arterial']);
            $materialMedico->setFrecuenciaCardiaca($fila['frecuencia_cardiaca']);
        } else {
            $materialMedico = null;
        }

        $conexion->Cerrar();
        return $materialMedico;
    }

    public function BuscarTodos() {
        $listaMaterialMedico = array();
        $conexion = new Conexion();
        $sql = "SELECT id, altura, peso, imc, condiciones_medicas, alergias, medicamentos, presion_arterial, frecuencia_cardiaca 
                FROM materialmedico;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $materialMedico = new MaterialMedico();
                $materialMedico->setId($fila['id']);
                $materialMedico->setAltura($fila['altura']);
                $materialMedico->setPeso($fila['peso']);
                $materialMedico->setImc($fila['imc']);
                $materialMedico->setCondicionesMedicas($fila['condiciones_medicas']);
                $materialMedico->setAlergias($fila['alergias']);
                $materialMedico->setMedicamentos($fila['medicamentos']);
                $materialMedico->setPresionArterial($fila['presion_arterial']);
                $materialMedico->setFrecuenciaCardiaca($fila['frecuencia_cardiaca']);
                $listaMaterialMedico[] = $materialMedico;
            }
        } else {
            $listaMaterialMedico = null;
        }

        $conexion->Cerrar();
        return $listaMaterialMedico;
    }

    public function Insertar(MaterialMedico $materialMedico) {
        // Calcular IMC automáticamente
        $materialMedico->calcularImc();

        $conexion = new Conexion();
        $sql = "INSERT INTO materialmedico (altura, peso, imc, condiciones_medicas, alergias, medicamentos, presion_arterial, frecuencia_cardiaca) 
                VALUES (" . $materialMedico->getAltura() . ", 
                " . $materialMedico->getPeso() . ", 
                " . $materialMedico->getImc() . ", 
                '" . $materialMedico->getCondicionesMedicas() . "', 
                '" . $materialMedico->getAlergias() . "', 
                '" . $materialMedico->getMedicamentos() . "', 
                '" . $materialMedico->getPresionArterial() . "', 
                '" . $materialMedico->getFrecuenciaCardiaca() . "');";

        $resultado = $conexion->Ejecutar($sql);

        if ($resultado) {
            // Obtener el ID insertado
            $idInsertado = $conexion->Ejecutar("SELECT LAST_INSERT_ID()");
            $id = $idInsertado->fetch_row()[0];
            $materialMedico->setId($id);
        }

        $conexion->Cerrar();
        return $resultado;
    }

    public function Actualizar(MaterialMedico $materialMedico) {
        // Recalcular IMC antes de actualizar
        $materialMedico->calcularImc();

        $conexion = new Conexion();
        $sql = "UPDATE materialmedico SET
                altura = " . $materialMedico->getAltura() . ",
                peso = " . $materialMedico->getPeso() . ",
                imc = " . $materialMedico->getImc() . ",
                condiciones_medicas = '" . $materialMedico->getCondicionesMedicas() . "',
                alergias = '" . $materialMedico->getAlergias() . "',
                medicamentos = '" . $materialMedico->getMedicamentos() . "',
                presion_arterial = '" . $materialMedico->getPresionArterial() . "',
                frecuencia_cardiaca = '" . $materialMedico->getFrecuenciaCardiaca() . "'
                WHERE id = " . $materialMedico->getId() . ";";

        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    public function Eliminar($id) {
        $conexion = new Conexion();
        $sql = "DELETE FROM materialmedico WHERE id = $id;";
        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }
}
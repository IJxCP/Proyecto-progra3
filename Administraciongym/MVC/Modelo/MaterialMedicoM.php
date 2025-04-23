<?php
require_once('C:/xampp/htdocs/Sistema_de_gym/MVC/Modelo/Conexion.php');
require_once('C:/xampp/htdocs/Sistema_de_gym/MVC/Entidades/MaterialMedico.php');

class MaterialMedicoM {
    public function BuscarId($id) {
        $materialMedico = new MaterialMedico();
        $conexion = new Conexion();
        $sql = "SELECT ID, ALTURA, PESO, IMC, CONDICIONES_MEDICAS, ALERGIAS, MEDICAMENTOS, PRESION_ARTERIAL, FRECUENCIA_CARDIACA 
        FROM materialmedico WHERE ID = $id;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $fila = $resultado->fetch_assoc();
            $materialMedico->setId($fila['ID']);
            $materialMedico->setAltura($fila['ALTURA']);
            $materialMedico->setPeso($fila['PESO']);
            $materialMedico->setImc($fila['IMC']);
            $materialMedico->setCondicionesMedicas($fila['CONDICIONES_MEDICAS']);
            $materialMedico->setAlergias($fila['ALERGIAS']);
            $materialMedico->setMedicamentos($fila['MEDICAMENTOS']);
            $materialMedico->setPresionArterial($fila['PRESION_ARTERIAL']);
            $materialMedico->setFrecuenciaCardiaca($fila['FRECUENCIA_CARDIACA']);
        } else {
            $materialMedico = null;
        }

        $conexion->Cerrar();
        return $materialMedico;
    }

    public function BuscarTodos() {
        $listaMaterialMedico = array();
        $conexion = new Conexion();
        $sql = "SELECT ID, ALTURA, PESO, IMC, CONDICIONES_MEDICAS, ALERGIAS, MEDICAMENTOS, PRESION_ARTERIAL, FRECUENCIA_CARDIACA 
                FROM material_medico;";
        $resultado = $conexion->Ejecutar($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $materialMedico = new MaterialMedico();
                $materialMedico->setId($fila['ID']);
                $materialMedico->setAltura($fila['ALTURA']);
                $materialMedico->setPeso($fila['PESO']);
                $materialMedico->setImc($fila['IMC']);
                $materialMedico->setCondicionesMedicas($fila['CONDICIONES_MEDICAS']);
                $materialMedico->setAlergias($fila['ALERGIAS']);
                $materialMedico->setMedicamentos($fila['MEDICAMENTOS']);
                $materialMedico->setPresionArterial($fila['PRESION_ARTERIAL']);
                $materialMedico->setFrecuenciaCardiaca($fila['FRECUENCIA_CARDIACA']);
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
        $sql = "INSERT INTO material_medico (ALTURA, PESO, IMC, CONDICIONES_MEDICAS, ALERGIAS, MEDICAMENTOS, PRESION_ARTERIAL, FRECUENCIA_CARDIACA) 
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
        $sql = "UPDATE material_medico SET
                ALTURA = " . $materialMedico->getAltura() . ",
                PESO = " . $materialMedico->getPeso() . ",
                IMC = " . $materialMedico->getImc() . ",
                CONDICIONES_MEDICAS = '" . $materialMedico->getCondicionesMedicas() . "',
                ALERGIAS = '" . $materialMedico->getAlergias() . "',
                MEDICAMENTOS = '" . $materialMedico->getMedicamentos() . "',
                PRESION_ARTERIAL = '" . $materialMedico->getPresionArterial() . "',
                FRECUENCIA_CARDIACA = '" . $materialMedico->getFrecuenciaCardiaca() . "'
                WHERE ID = " . $materialMedico->getId() . ";";

        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }

    public function Eliminar($id) {
        $conexion = new Conexion();
        $sql = "DELETE FROM material_medico WHERE ID = $id;";
        $resultado = $conexion->Ejecutar($sql);
        $conexion->Cerrar();
        return $resultado;
    }
}
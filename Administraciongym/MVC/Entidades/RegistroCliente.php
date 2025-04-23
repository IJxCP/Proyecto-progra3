<?php
class RegistroCliente {
    private $id;
    private $idDatosPersonales;
    private $idMaterialMedico;
    private $fechaRegistro;
    private $objetivos;
    private $notas;
    private $datosAdicionales; // Para almacenar datos adicionales no persistentes

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getIdDatosPersonales() { return $this->idDatosPersonales; }
    public function setIdDatosPersonales($idDatosPersonales) { $this->idDatosPersonales = $idDatosPersonales; }

    public function getIdMaterialMedico() { return $this->idMaterialMedico; }
    public function setIdMaterialMedico($idMaterialMedico) { $this->idMaterialMedico = $idMaterialMedico; }

    public function getFechaRegistro() { return $this->fechaRegistro; }
    public function setFechaRegistro($fechaRegistro) { $this->fechaRegistro = $fechaRegistro; }

    public function getObjetivos() { return $this->objetivos; }
    public function setObjetivos($objetivos) { $this->objetivos = $objetivos; }

    public function getNotas() { return $this->notas; }
    public function setNotas($notas) { $this->notas = $notas; }

    // Métodos para datos adicionales (como nombre completo, etc.)
    public function getDatosAdicionales($clave = null) {
        if ($clave !== null && isset($this->datosAdicionales[$clave])) {
            return $this->datosAdicionales[$clave];
        }
        return $this->datosAdicionales;
    }

    public function setDatosAdicionales($datosAdicionales) {
        $this->datosAdicionales = $datosAdicionales;
    }

    // Método de conveniencia para obtener el nombre completo
    public function getNombreCompleto() {
        if (isset($this->datosAdicionales['nombreCompleto'])) {
            return $this->datosAdicionales['nombreCompleto'];
        }
        return '';
    }
}
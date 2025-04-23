<?php
class GestionDatos {
    private $id;
    private $idCliente;
    private $idStatus;
    private $fechaUltimaActualizacion;
    private $observaciones;
    private $datosAdicionales; // Para almacenar datos adicionales no persistentes

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getIdCliente() { return $this->idCliente; }
    public function setIdCliente($idCliente) { $this->idCliente = $idCliente; }

    public function getIdStatus() { return $this->idStatus; }
    public function setIdStatus($idStatus) { $this->idStatus = $idStatus; }

    public function getFechaUltimaActualizacion() { return $this->fechaUltimaActualizacion; }
    public function setFechaUltimaActualizacion($fechaUltimaActualizacion) { $this->fechaUltimaActualizacion = $fechaUltimaActualizacion; }

    public function getObservaciones() { return $this->observaciones; }
    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }

    // Métodos para datos adicionales
    public function getDatosAdicionales($clave = null) {
        if ($clave !== null && isset($this->datosAdicionales[$clave])) {
            return $this->datosAdicionales[$clave];
        }
        return $this->datosAdicionales;
    }

    public function setDatosAdicionales($datosAdicionales) {
        $this->datosAdicionales = $datosAdicionales;
    }

    // Método de conveniencia para obtener el nombre del status
    public function getNombreStatus() {
        if (isset($this->datosAdicionales['nombre_status'])) {
            return $this->datosAdicionales['nombre_status'];
        }
        return '';
    }

    // Método de conveniencia para obtener el nombre completo del cliente
    public function getNombreCliente() {
        if (isset($this->datosAdicionales['nombreCompleto'])) {
            return $this->datosAdicionales['nombreCompleto'];
        }
        return '';
    }
}
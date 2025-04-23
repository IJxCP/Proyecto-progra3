<?php
class GestionCuotas {
    private $id;
    private $idInscripcion;
    private $fechaPago;
    private $monto;
    private $metodoPago;
    private $comprobante;
    private $estado; // Pagado, Pendiente, Atrasado
    private $observaciones;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getIdInscripcion() { return $this->idInscripcion; }
    public function setIdInscripcion($idInscripcion) { $this->idInscripcion = $idInscripcion; }

    public function getFechaPago() { return $this->fechaPago; }
    public function setFechaPago($fechaPago) { $this->fechaPago = $fechaPago; }

    public function getMonto() { return $this->monto; }
    public function setMonto($monto) { $this->monto = $monto; }

    public function getMetodoPago() { return $this->metodoPago; }
    public function setMetodoPago($metodoPago) { $this->metodoPago = $metodoPago; }

    public function getComprobante() { return $this->comprobante; }
    public function setComprobante($comprobante) { $this->comprobante = $comprobante; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }

    public function getObservaciones() { return $this->observaciones; }
    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }
}
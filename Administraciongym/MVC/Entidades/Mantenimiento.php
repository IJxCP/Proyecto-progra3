<?php
class Mantenimiento {
    private $id;
    private $descripcion;
    private $fecha;
    private $responsable;
    private $estado;

    // Constructor
    public function __construct($id = null, $descripcion = null, $fecha = null, $responsable = null, $estado = null) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->responsable = $responsable;
        $this->estado = $estado;
    }

    // Getters y setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getFecha() { return $this->fecha; }
    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getResponsable() { return $this->responsable; }
    public function setResponsable($responsable) { $this->responsable = $responsable; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }
}


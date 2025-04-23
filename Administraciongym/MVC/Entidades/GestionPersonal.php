<?php
class GestionPersonal {
    private $id;
    private $nombre;
    private $puesto;
    private $fecha_ingreso;
    private $correo;
    private $telefono;
    private $estado;

    public function __construct($id = null, $nombre = null, $puesto = null, $fecha_ingreso = null, $correo = null, $telefono = null, $estado = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->puesto = $puesto;
        $this->fecha_ingreso = $fecha_ingreso;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->estado = $estado;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getPuesto() { return $this->puesto; }
    public function setPuesto($puesto) { $this->puesto = $puesto; }

    public function getFechaIngreso() { return $this->fecha_ingreso; }
    public function setFechaIngreso($fecha_ingreso) { $this->fecha_ingreso = $fecha_ingreso; }

    public function getCorreo() { return $this->correo; }
    public function setCorreo($correo) { $this->correo = $correo; }

    public function getTelefono() { return $this->telefono; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }
}


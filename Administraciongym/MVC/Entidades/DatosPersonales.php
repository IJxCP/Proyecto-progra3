<?php
class DatosPersonales {
    private $id;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $fechaNacimiento;
    private $telefono;
    private $correo;
    private $direccion;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getApellido1() { return $this->apellido1; }
    public function setApellido1($apellido1) { $this->apellido1 = $apellido1; }

    public function getApellido2() { return $this->apellido2; }
    public function setApellido2($apellido2) { $this->apellido2 = $apellido2; }

    public function getFechaNacimiento() { return $this->fechaNacimiento; }
    public function setFechaNacimiento($fechaNacimiento) { $this->fechaNacimiento = $fechaNacimiento; }

    public function getTelefono() { return $this->telefono; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getCorreo() { return $this->correo; }
    public function setCorreo($correo) { $this->correo = $correo; }

    public function getDireccion() { return $this->direccion; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
}
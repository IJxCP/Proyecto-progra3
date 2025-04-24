<?php

class Usuario {
    private $id;
    private $usuario;
    private $contrasena;

    // Constructor
    public function __construct($id = null, $usuario = null, $contrasena = null) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }


    public function encriptarContrasena() {
        $this->contrasena = password_hash($this->contrasena, PASSWORD_DEFAULT);
    }


    public function verificarContrasena($contrasenaPlana) {
        return password_verify($contrasenaPlana, $this->contrasena);
    }
}
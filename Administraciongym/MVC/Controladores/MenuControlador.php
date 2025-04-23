<?php
require_once 'MVC/Controladores/UsuarioControlador.php';

class MenuControlador {
    public function __construct() {
        // No necesitamos verificación adicional aquí ya que
        // la verificación de autenticación ya se realiza en Index.php
    }

    public function index() {
        include 'MVC/Vista/Menu/Menu.php';
    }
}
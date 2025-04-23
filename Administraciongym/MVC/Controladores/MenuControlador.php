<?php
require_once 'MVC/Controladores/UsuarioControlador.php';

class MenuControlador {
    public function __construct() {
        // Verificar que el usuario esté autenticado
        UsuarioControlador::verificarAutenticacion();
    }


    public function index() {
        include 'MVC/Vista/Menu/Menu.php';
    }


    public function ayuda() {
        include 'MVC/Vista/Menu/Ayuda.php';
    }


    public function acercaDe() {
        include 'MVC/Vista/Menu/AcercaDe.php';
    }



    public function perfil() {
        if (!isset($_SESSION['id'])) {
            header("Location: index.php?controlador=usuario&accion=login");
            exit();
        }

        require_once 'MVC/Modelo/UsuarioM.php';
        $usuarioM = new UsuarioM();
        $usuario = $usuarioM->obtenerUsuarioM($_SESSION['id']);

        include 'MVC/Vista/Menu/Perfil.php';
    }

    /**
     * Método para mostrar el panel de control con estadísticas
     */
    public function panel() {
        // Aquí podrías cargar datos para mostrar en el panel como estadísticas, etc.
        include 'MVC/Vista/Menu/Panel.php';
    }
}
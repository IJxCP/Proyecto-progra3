<?php

session_start();


define('BASE_PATH', __DIR__);


spl_autoload_register(function($clase) {

    $rutas = [
        BASE_PATH . '/MVC/Controladores/',
        BASE_PATH . '/MVC/Modelo/',
        BASE_PATH . '/MVC/Entidades/',
        BASE_PATH . '/MVC/Vista/'
    ];

    foreach ($rutas as $ruta) {
        $archivo = $ruta . $clase . '.php';
        if (file_exists($archivo)) {
            require_once $archivo;
            return;
        }
    }
});


require_once 'Conexion.php';
require_once 'MVC/Modelo/Utilidades.php';


$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'menu';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'index';


$requiereAutenticacion = true;


if ($controlador === 'usuario' && ($accion === 'login' || $accion === 'iniciarSesion')) {
    $requiereAutenticacion = false;
}


if ($requiereAutenticacion && (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
    header("Location: MVC/Vista/InicioSesion/InicioSesion.php");
    exit();
}


$controladores = [
    'usuario' => 'UsuarioControlador',
    'cliente' => 'ClienteControlador',
    'cuota' => 'CuotaControlador',
    'inscripcion' => 'InscripcionControlador',
    'inventario' => 'InventarioControlador',
    'mantenimiento' => 'MantenimientoControlador',
    'gestiondatos' => 'GestionDatosControlador',
    'gestionpersonal' => 'GestionPersonalControlador',
    'status' => 'StatusControlador',
    'analisisdatos' => 'AnalisisDatosControlador',
    'menu' => 'MenuControlador'
];


if (!array_key_exists($controlador, $controladores)) {
    echo "Error: Controlador no encontrado: $controlador";
    exit;
}


$nombreControlador = $controladores[$controlador];


if (!class_exists($nombreControlador)) {
    echo "Error: Clase del controlador no encontrada: $nombreControlador";
    exit;
}


try {

    $controladorObj = new $nombreControlador();

    // Verificar si el método existe
    if (!method_exists($controladorObj, $accion)) {
        echo "Error: Acción no encontrada: $accion en $nombreControlador";
        exit;
    }


    $controladorObj->$accion();

} catch (Exception $e) {
    echo "Error al ejecutar la acción: " . $e->getMessage();
}
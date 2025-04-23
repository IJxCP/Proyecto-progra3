<?php
// Archivo principal de enrutamiento
session_start();

// Definir la ruta base del proyecto
define('BASE_PATH', __DIR__);

// Implementar autoloader para cargar clases automáticamente
spl_autoload_register(function($clase) {
    // Rutas donde buscar las clases
    $rutas = [
        BASE_PATH . '/MVC/Controladores/',
        BASE_PATH . '/MVC/Modelo/',
        BASE_PATH . '/MVC/Entidades/',
        BASE_PATH . '/MVC/Vistas/'
    ];

    foreach ($rutas as $ruta) {
        $archivo = $ruta . $clase . '.php';
        if (file_exists($archivo)) {
            require_once $archivo;
            return;
        }
    }
});

// Incluir solo la conexión a base de datos y utilidades
require_once 'Conexion.php';
require_once 'MVC/Modelo/Utilidades.php';


// Verificar si el usuario está autenticado excepto para el controlador de usuario
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    if (!isset($_GET['controlador']) || $_GET['controlador'] !== 'usuario') {
        header("Location: MVC/Vista/InicioSesion/InicioSesion.php");
        exit();
    }
}

// Definir controlador y acción por defecto
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'menu';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'index';

// Mapeo de controladores
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

// Verificar si el controlador existe
if (!array_key_exists($controlador, $controladores)) {
    echo "Error: Controlador no encontrado";
    exit;
}

// Si el controlador es menú, incluir ese archivo específico
if ($controlador === 'menu') {
    require_once 'MVC/Vista/Menu/Menu.php';
    exit;
}

// Construir el nombre de la clase del controlador
$nombreControlador = $controladores[$controlador];

// Verificar si la clase existe (debería existir gracias al autoloader)
if (!class_exists($nombreControlador)) {
    echo "Error: Clase del controlador no encontrada: $nombreControlador";
    exit;
}

// Instanciar el controlador
$controladorObj = new $nombreControlador();

// Verificar si el método existe
if (!method_exists($controladorObj, $accion)) {
    echo "Error: Acción no encontrada: $accion";
    exit;
}

// Ejecutar la acción del controlador
$controladorObj->$accion();
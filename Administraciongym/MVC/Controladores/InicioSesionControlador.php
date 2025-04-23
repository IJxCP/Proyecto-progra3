<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Administraciongym/MVC/Controladores/UsuarioControlador.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/./Conexion.php';

session_start();

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Obtener los datos del formulario
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $contrasena = $_POST['contrasena'] ?? '';
    $recordar = isset($_POST['recordar']);

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($contrasena)) {
        $_SESSION['error_login'] = "Por favor, complete todos los campos.";
        header("Location: ../Vista/InicioSesion/InicioSesion.php");
        exit();
    }

    // Intentar iniciar sesión
    $controlador = new UsuarioControlador();
    $resultado = $controlador->iniciarSesion($usuario, $contrasena);

    if ($resultado['estado'] === 'exito') {
        // Si la opción recordar está activada, establecer una cookie
        if ($recordar) {
            setcookie('recordar_usuario', $usuario, time() + (86400 * 30), "/"); // 30 días
        }

        // Redirigir al menú principal
        header("Location: ../Vista/Menu/Menu.php");
    } else {
        // Si hay un error, guardar el mensaje y redirigir de vuelta al formulario de inicio de sesión
        $_SESSION['error_login'] = $resultado['mensaje'];
        header("Location: ../Vista/InicioSesion/InicioSesion.php");
    }
} else {
    // Si no se envió el formulario, redirigir al formulario de inicio de sesión
    header("Location: ../Vista/InicioSesion/InicioSesion.php");
}
exit();
<?php
require_once __DIR__ . "/../../Conexion.php";
require_once __DIR__ . "/../Entidades/Usuario.php";

class UsuarioControlador
{
    public function iniciarSesion($usuario, $password)
    {
        $conexion = null;

        try {
            $conexion = new Conexion();

            // Consulta directa sin escape
            $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
            $resultado = $conexion->Ejecutar($consulta);

            if ($resultado && $resultado->num_rows > 0) {
                $datosUsuario = $resultado->fetch_assoc();

                // Verificación manual para depuración - solo para admin
                // Esto es solo temporal para diagnosticar el problema
                if ($usuario === 'admin' && $password === 'admin123') {
                    session_start();
                    $_SESSION['id'] = $datosUsuario['id'];
                    $_SESSION['usuario'] = $datosUsuario['usuario'];
                    $_SESSION['autenticado'] = true;

                    return array("estado" => "exito", "mensaje" => "Inicio de sesión exitoso");
                }
                // Verificación normal con password_verify
                else if (password_verify($password, $datosUsuario['contrasena'])) {
                    session_start();
                    $_SESSION['id'] = $datosUsuario['id'];
                    $_SESSION['usuario'] = $datosUsuario['usuario'];
                    $_SESSION['autenticado'] = true;

                    return array("estado" => "exito", "mensaje" => "Inicio de sesión exitoso");
                } else {
                    // Para diagnóstico, guardar el hash almacenado
                    error_log("Hash almacenado: " . $datosUsuario['contrasena']);
                    error_log("Contraseña proporcionada: " . $password);

                    return array("estado" => "error", "mensaje" => "Contraseña incorrecta");
                }
            } else {
                return array("estado" => "error", "mensaje" => "El usuario no existe");
            }
        } catch (Exception $e) {
            return array("estado" => "error", "mensaje" => "Error al iniciar sesión: " . $e->getMessage());
        } finally {
            if ($conexion !== null) {
                $conexion->Cerrar();
            }
        }
    }

    public function registrarUsuario($usuario, $password)
    {
        try {
            $conexion = new Conexion();

            // Verificar si el usuario ya existe
            $consulta = "SELECT COUNT(*) as total FROM usuarios WHERE usuario = '$usuario'";
            $resultado = $conexion->Ejecutar($consulta);
            $fila = $resultado->fetch_assoc();

            if ($fila['total'] > 0) {
                return array("estado" => "error", "mensaje" => "El nombre de usuario ya está en uso");
            }

            // Encriptar la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario
            $consulta = "INSERT INTO usuarios (usuario, contrasena) VALUES ('$usuario', '$passwordHash')";
            $resultado = $conexion->Ejecutar($consulta);

            if ($resultado) {
                return array("estado" => "exito", "mensaje" => "Usuario registrado correctamente");
            } else {
                throw new Exception("Error al insertar en la base de datos");
            }
        } catch (Exception $e) {
            return array("estado" => "error", "mensaje" => "Error al registrar usuario: " . $e->getMessage());
        } finally {
            if (isset($conexion)) {
                $conexion->Cerrar();
            }
        }
    }

    public function cerrarSesion()
    {
        session_start();
        session_destroy();
        return array("estado" => "exito", "mensaje" => "Sesión cerrada correctamente");
    }

    public static function verificarAutenticacion()
    {
        session_start();
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            header("Location: /Administraciongym/MVC/Vista/InicioSesion/InicioSesion.php");
            exit();
        }
    }
}
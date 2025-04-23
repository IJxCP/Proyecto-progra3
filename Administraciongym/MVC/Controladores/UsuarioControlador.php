<?php
require_once __DIR__ . "/../../Conexion.php";
require_once __DIR__ . "/../Entidades/Usuario.php";

class UsuarioControlador
{

    public function iniciarSesion($usuario, $password)
    {
        $conexion = null; // Inicializa la variable antes del try

        try {
            $conexion = new Conexion();

            $usuario = $conexion->mysqli->real_escape_string($usuario);

            $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
            $resultado = $conexion->Ejecutar($consulta);

            if ($resultado && $resultado->num_rows > 0) {
                $datosUsuario = $resultado->fetch_assoc();

                if (password_verify($password, $datosUsuario['contrasena'])) {
                    session_start();
                    $_SESSION['id'] = $datosUsuario['id'];
                    $_SESSION['usuario'] = $datosUsuario['usuario'];
                    $_SESSION['autenticado'] = true;

                    return array("estado" => "exito", "mensaje" => "Inicio de sesión exitoso");
                } else {
                    return array("estado" => "error", "mensaje" => "Contraseña incorrecta");
                }
            } else {
                return array("estado" => "error", "mensaje" => "El usuario no existe");
            }
        } catch (Exception $e) {
            return array("estado" => "error", "mensaje" => "Error al iniciar sesión: " . $e->getMessage());
        } finally {
            // Verificamos que $conexion exista antes de intentar cerrarla
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
            $usuario = $conexion->mysqli->real_escape_string($usuario);
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
            $conexion->Cerrar();
        }
    }


    public function cerrarSesion()
    {
        session_start();
        session_destroy();
        return array("estado" => "exito", "mensaje" => "Sesión cerrada correctamente");
    }


    public function listarUsuarios()
    {
        try {
            $conexion = new Conexion();
            $consulta = "SELECT id, usuario FROM usuarios";
            $resultado = $conexion->Ejecutar($consulta);

            $usuarios = array();

            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $usuarios[] = $fila;
                }
            }

            return $usuarios;
        } catch (Exception $e) {
            return array("estado" => "error", "mensaje" => "Error al listar usuarios: " . $e->getMessage());
        } finally {
            $conexion->Cerrar();
        }
    }


    public function obtenerUsuario($id)
    {
        try {
            $conexion = new Conexion();
            $id = (int)$id; // Asegurar que es un entero

            $consulta = "SELECT id, usuario FROM usuarios WHERE id = $id";
            $resultado = $conexion->Ejecutar($consulta);

            if ($resultado && $resultado->num_rows > 0) {
                return $resultado->fetch_assoc();
            } else {
                return null;
            }
        } catch (Exception $e) {
            return array("estado" => "error", "mensaje" => "Error al obtener usuario: " . $e->getMessage());
        } finally {
            $conexion->Cerrar();
        }
    }


    public function actualizarUsuario($id, $usuario, $password = null)
    {
        try {
            $conexion = new Conexion();
            $id = (int)$id; // Asegurar que es un entero
            $usuario = $conexion->mysqli->real_escape_string($usuario);

            // Si se proporciona una nueva contraseña, actualizarla también
            if ($password) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $consulta = "UPDATE usuarios SET usuario = '$usuario', contrasena = '$passwordHash' WHERE id = $id";
            } else {
                $consulta = "UPDATE usuarios SET usuario = '$usuario' WHERE id = $id";
            }

            $resultado = $conexion->Ejecutar($consulta);

            if ($resultado) {
                return array("estado" => "exito", "mensaje" => "Usuario actualizado correctamente");
            } else {
                return array("estado" => "error", "mensaje" => "No se pudo actualizar el usuario");
            }
        } catch (Exception $e) {
            return array("estado" => "error", "mensaje" => "Error al actualizar usuario: " . $e->getMessage());
        } finally {
            $conexion->Cerrar();
        }
    }


    public function eliminarUsuario($id)
    {
        try {
            $conexion = new Conexion();
            $id = (int)$id; // Asegurar que es un entero

            $consulta = "DELETE FROM usuarios WHERE id = $id";
            $resultado = $conexion->Ejecutar($consulta);

            if ($resultado) {
                return array("estado" => "exito", "mensaje" => "Usuario eliminado correctamente");
            } else {
                return array("estado" => "error", "mensaje" => "No se pudo eliminar el usuario");
            }
        } catch (Exception $e) {
            return array("estado" => "error", "mensaje" => "Error al eliminar usuario: " . $e->getMessage());
        } finally {
            $conexion->Cerrar();
        }
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
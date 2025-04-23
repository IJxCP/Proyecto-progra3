<?php

require_once "Conexion.php";

class UsuarioM {

    // Método para iniciar sesión
    static public function iniciarSesionM($usuario) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Método para registrar nuevo usuario
    static public function registrarUsuarioM($datos) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO usuarios(usuario, contrasena) VALUES (:usuario, :contrasena)");

        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":contrasena", $datos["contrasena"], PDO::PARAM_STR);

        if($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }


    static public function mostrarUsuariosM() {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll();
    }


    static public function obtenerUsuarioM($id) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Método para editar usuario
    static public function editarUsuarioM($datos) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("UPDATE usuarios SET usuario = :usuario, contrasena = :contrasena WHERE id = :id");

        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":contrasena", $datos["contrasena"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    // Método para cambiar solo la contraseña
    static public function cambiarContrasenaM($id, $nuevaContrasena) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("UPDATE usuarios SET contrasena = :contrasena WHERE id = :id");

        $stmt->bindParam(":contrasena", $nuevaContrasena, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    // Método para eliminar usuario
    static public function eliminarUsuarioM($id) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    // Método para verificar si un usuario ya existe (evitar duplicados)
    static public function verificarUsuarioExistenteM($usuario) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();

        return ($stmt->fetchColumn() > 0);
    }
}
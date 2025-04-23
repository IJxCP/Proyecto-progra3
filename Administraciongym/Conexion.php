<?php
class Conexion
{
    public $mysqli;
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $name = "Administraciongym";

    public function __construct()
    {
        try {
            $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->name);

            if ($this->mysqli->connect_error) {
                die("Error en la conexión a la base: " . $this->mysqli->connect_error);
            }

            $this->mysqli->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function Ejecutar($sql)
    {
        return $this->mysqli->query($sql);
    }

    public function Cerrar()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
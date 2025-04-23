<?php
class Conexion
{
    public $mysqli;
    private $host = "localhost";
    private $user = "admin";
    private $pass = "YES";
    private $name = "Administraciongym"; //

    public function __construct()
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->name);
        if ($this->mysqli->connect_error) {
            die("Error en la conexión a la base: " . $this->mysqli->connect_error);
        }
        $this->mysqli->set_charset("utf8mb4");
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


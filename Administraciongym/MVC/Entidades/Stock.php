<?php
class Stock {
    private $id;
    private $nombre_item;
    private $descripcion;
    private $cantidad;
    private $categoria;
    private $fecha_ingreso;
    private $estado;

    public function __construct($id = null, $nombre_item = null, $descripcion = null, $cantidad = null, $categoria = null, $fecha_ingreso = null, $estado = null) {
        $this->id = $id;
        $this->nombre_item = $nombre_item;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
        $this->categoria = $categoria;
        $this->fecha_ingreso = $fecha_ingreso;
        $this->estado = $estado;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNombreItem() { return $this->nombre_item; }
    public function setNombreItem($nombre_item) { $this->nombre_item = $nombre_item; }

    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getCantidad() { return $this->cantidad; }
    public function setCantidad($cantidad) { $this->cantidad = $cantidad; }

    public function getCategoria() { return $this->categoria; }
    public function setCategoria($categoria) { $this->categoria = $categoria; }

    public function getFechaIngreso() { return $this->fecha_ingreso; }
    public function setFechaIngreso($fecha_ingreso) { $this->fecha_ingreso = $fecha_ingreso; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }
}


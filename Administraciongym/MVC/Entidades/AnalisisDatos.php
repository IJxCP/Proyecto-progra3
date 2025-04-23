<?php
class AnalisisDatos {
    private $id;
    private $idcliente;
    private $fecha;
    private $tipo_analisis;
    private $resultado;
    private $observaciones;
    private $datosAdicionales; // Para almacenar datos adicionales no persistentes

    public function __construct($id = null, $idcliente = null, $fecha = null, $tipo_analisis = null, $resultado = null, $observaciones = null) {
        $this->id = $id;
        $this->idcliente = $idcliente;
        $this->fecha = $fecha;
        $this->tipo_analisis = $tipo_analisis;
        $this->resultado = $resultado;
        $this->observaciones = $observaciones;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getIdcliente() { return $this->idcliente; }
    public function setIdcliente($idcliente) { $this->idcliente = $idcliente; }

    public function getFecha() { return $this->fecha; }
    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getTipoAnalisis() { return $this->tipo_analisis; }
    public function setTipoAnalisis($tipo_analisis) { $this->tipo_analisis = $tipo_analisis; }

    public function getResultado() { return $this->resultado; }
    public function setResultado($resultado) { $this->resultado = $resultado; }

    public function getObservaciones() { return $this->observaciones; }
    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }

    // Métodos para datos adicionales
    public function getDatosAdicionales($clave = null) {
        if ($clave !== null && isset($this->datosAdicionales[$clave])) {
            return $this->datosAdicionales[$clave];
        }
        return $this->datosAdicionales;
    }

    public function setDatosAdicionales($datosAdicionales) {
        $this->datosAdicionales = $datosAdicionales;
    }

    // Método de conveniencia para obtener el nombre completo del cliente
    public function getNombreCliente() {
        if (isset($this->datosAdicionales['nombreCompleto'])) {
            return $this->datosAdicionales['nombreCompleto'];
        }
        return '';
    }

    // Formato para la fecha
    public function getFechaFormateada() {
        if (!empty($this->fecha)) {
            return date('d/m/Y', strtotime($this->fecha));
        }
        return '';
    }
}
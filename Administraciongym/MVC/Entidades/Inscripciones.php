<?php
class Inscripcion {
    private $id;
    private $idGestionDatos;
    private $fechaInscripcion;
    private $fechaVencimiento;
    private $tipoMembresia; // Mensual, trimestral, anual, etc.
    private $monto;
    private $datosAdicionales; // Almacena datos adicionales no persistentes

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getIdGestionDatos() { return $this->idGestionDatos; }
    public function setIdGestionDatos($idGestionDatos) { $this->idGestionDatos = $idGestionDatos; }

    public function getFechaInscripcion() { return $this->fechaInscripcion; }
    public function setFechaInscripcion($fechaInscripcion) { $this->fechaInscripcion = $fechaInscripcion; }

    public function getFechaVencimiento() { return $this->fechaVencimiento; }
    public function setFechaVencimiento($fechaVencimiento) { $this->fechaVencimiento = $fechaVencimiento; }

    public function getTipoMembresia() { return $this->tipoMembresia; }
    public function setTipoMembresia($tipoMembresia) { $this->tipoMembresia = $tipoMembresia; }

    public function getMonto() { return $this->monto; }
    public function setMonto($monto) { $this->monto = $monto; }

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

    // Comprobar si una inscripción está vigente
    public function esVigente() {
        $fechaActual = new DateTime();
        $fechaVencimiento = new DateTime($this->fechaVencimiento);
        return $fechaActual <= $fechaVencimiento;
    }

    // Obtener días restantes hasta vencimiento (o días vencidos)
    public function diasHastaVencimiento() {
        $fechaActual = new DateTime();
        $fechaVencimiento = new DateTime($this->fechaVencimiento);
        $diferencia = $fechaActual->diff($fechaVencimiento);

        if ($fechaActual > $fechaVencimiento) {
            return -$diferencia->days; // Días vencidos (número negativo)
        } else {
            return $diferencia->days; // Días restantes
        }
    }
}
<?php
class MaterialMedico {
    private $id;
    private $altura;
    private $peso;
    private $imc; // Índice de Masa Corporal
    private $condicionesMedicas;
    private $alergias;
    private $medicamentos;
    private $presionArterial;
    private $frecuenciaCardiaca;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getAltura() { return $this->altura; }
    public function setAltura($altura) { $this->altura = $altura; }

    public function getPeso() { return $this->peso; }
    public function setPeso($peso) { $this->peso = $peso; }

    public function getImc() { return $this->imc; }
    public function setImc($imc) { $this->imc = $imc; }

    // Método para calcular IMC automáticamente
    public function calcularImc() {
        if ($this->altura > 0 && $this->peso > 0) {
            // IMC = peso (kg) / (altura (m))²
            $alturaEnMetros = $this->altura / 100; // Convertir cm a metros
            $this->imc = round($this->peso / ($alturaEnMetros * $alturaEnMetros), 2);
        }
        return $this->imc;
    }

    public function getCondicionesMedicas() { return $this->condicionesMedicas; }
    public function setCondicionesMedicas($condicionesMedicas) { $this->condicionesMedicas = $condicionesMedicas; }

    public function getAlergias() { return $this->alergias; }
    public function setAlergias($alergias) { $this->alergias = $alergias; }

    public function getMedicamentos() { return $this->medicamentos; }
    public function setMedicamentos($medicamentos) { $this->medicamentos = $medicamentos; }

    public function getPresionArterial() { return $this->presionArterial; }
    public function setPresionArterial($presionArterial) { $this->presionArterial = $presionArterial; }

    public function getFrecuenciaCardiaca() { return $this->frecuenciaCardiaca; }
    public function setFrecuenciaCardiaca($frecuenciaCardiaca) { $this->frecuenciaCardiaca = $frecuenciaCardiaca; }
}
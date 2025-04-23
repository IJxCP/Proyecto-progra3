<?php
class Utilidades {
    /**
     * Genera un mensaje de alerta para mostrar en la interfaz
     *
     * @param string $tipo Tipo de alerta (success, danger, warning, info)
     * @param string $mensaje Mensaje a mostrar
     * @return string HTML para mostrar la alerta
     */
    public static function generarAlerta($tipo, $mensaje) {
        return '<div class="alert alert-' . $tipo . ' alert-dismissible fade show" role="alert">
                    ' . $mensaje . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }

    /**
     * Valida un correo electrónico
     *
     * @param string $email Correo a validar
     * @return bool True si es válido, false si no
     */
    public static function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Formatea una fecha en formato MySQL a formato legible
     *
     * @param string $fecha Fecha en formato YYYY-MM-DD
     * @return string Fecha en formato DD/MM/YYYY
     */
    public static function formatearFecha($fecha) {
        if (empty($fecha)) return '';
        $timestamp = strtotime($fecha);
        return date('d/m/Y', $timestamp);
    }

    /**
     * Limpia y sanitiza una cadena para prevenir inyección SQL
     *
     * @param string $cadena Cadena a limpiar
     * @return string Cadena limpia
     */
    public static function limpiarCadena($cadena) {
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = htmlspecialchars($cadena);
        return $cadena;
    }

    /**
     * Genera un ID único para registros
     *
     * @param string $prefijo Prefijo para el ID (opcional)
     * @return string ID único
     */
    public static function generarID($prefijo = '') {
        $uniqueId = uniqid($prefijo, true);
        return $prefijo . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3) . substr($uniqueId, -8);
    }

    /**
     * Calcula el IMC basado en peso y altura
     *
     * @param float $peso Peso en kg
     * @param float $altura Altura en cm
     * @return float|null IMC calculado o null si los datos son inválidos
     */
    public static function calcularIMC($peso, $altura) {
        if ($peso <= 0 || $altura <= 0) {
            return null;
        }

        $alturaMetros = $altura / 100; // Convertir cm a metros
        return round($peso / ($alturaMetros * $alturaMetros), 2);
    }

    /**
     * Obtiene la clasificación del IMC
     *
     * @param float $imc IMC calculado
     * @return string Clasificación del IMC
     */
    public static function clasificacionIMC($imc) {
        if ($imc < 18.5) {
            return 'Bajo peso';
        } elseif ($imc >= 18.5 && $imc < 25) {
            return 'Peso normal';
        } elseif ($imc >= 25 && $imc < 30) {
            return 'Sobrepeso';
        } elseif ($imc >= 30 && $imc < 35) {
            return 'Obesidad grado I';
        } elseif ($imc >= 35 && $imc < 40) {
            return 'Obesidad grado II';
        } else {
            return 'Obesidad grado III';
        }
    }

    /**
     * Calcula la edad a partir de la fecha de nacimiento
     *
     * @param string $fechaNacimiento Fecha de nacimiento en formato YYYY-MM-DD
     * @return int|null Edad calculada o null si la fecha es inválida
     */
    public static function calcularEdad($fechaNacimiento) {
        if (empty($fechaNacimiento)) {
            return null;
        }

        $fechaNac = new DateTime($fechaNacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNac);
        return $edad->y;
    }

    /**
     * Calcula la fecha de vencimiento de una membresía
     *
     * @param string $fechaInicio Fecha de inicio en formato YYYY-MM-DD
     * @param string $tipoMembresia Tipo de membresía (mensual, trimestral, semestral, anual)
     * @return string Fecha de vencimiento en formato YYYY-MM-DD
     */
    public static function calcularFechaVencimiento($fechaInicio, $tipoMembresia) {
        $fecha = new DateTime($fechaInicio);

        switch (strtolower($tipoMembresia)) {
            case 'mensual':
                $fecha->add(new DateInterval('P1M'));
                break;
            case 'trimestral':
                $fecha->add(new DateInterval('P3M'));
                break;
            case 'semestral':
                $fecha->add(new DateInterval('P6M'));
                break;
            case 'anual':
                $fecha->add(new DateInterval('P1Y'));
                break;
            default:
                $fecha->add(new DateInterval('P1M'));
        }

        return $fecha->format('Y-m-d');
    }

    /**
     * Comprueba si una membresía está vencida
     *
     * @param string $fechaVencimiento Fecha de vencimiento en formato YYYY-MM-DD
     * @return bool True si está vencida, false si no
     */
    public static function esMembresiaVencida($fechaVencimiento) {
        $hoy = new DateTime();
        $vencimiento = new DateTime($fechaVencimiento);
        return $hoy > $vencimiento;
    }

    /**
     * Calcula los días restantes para el vencimiento de una membresía
     *
     * @param string $fechaVencimiento Fecha de vencimiento en formato YYYY-MM-DD
     * @return int Días restantes (negativo si ya venció)
     */
    public static function diasParaVencimiento($fechaVencimiento) {
        $hoy = new DateTime();
        $vencimiento = new DateTime($fechaVencimiento);
        $intervalo = $hoy->diff($vencimiento);
        return $intervalo->invert ? -$intervalo->days : $intervalo->days;
    }

    /**
     * Redirecciona a una URL específica
     *
     * @param string $url URL a donde redireccionar
     */
    public static function redireccionar($url) {
        header("Location: $url");
        exit();
    }

    /**
     * Formatea un número como moneda
     *
     * @param float $monto Monto a formatear
     * @param string $simbolo Símbolo de moneda (opcional)
     * @return string Monto formateado
     */
    public static function formatearMoneda($monto, $simbolo = '$') {
        return $simbolo . ' ' . number_format($monto, 2, '.', ',');
    }

    /**
     * Registra un mensaje en el log del sistema
     *
     * @param string $mensaje Mensaje a registrar
     * @param string $tipo Tipo de mensaje (INFO, ERROR, WARNING)
     */
    public static function registrarLog($mensaje, $tipo = 'INFO') {
        $rutaLog = BASE_PATH . '/logs';

        // Crear directorio de logs si no existe
        if (!file_exists($rutaLog)) {
            mkdir($rutaLog, 0755, true);
        }

        $archivo = $rutaLog . '/app_' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        $mensaje = "[$timestamp][$tipo] $mensaje" . PHP_EOL;

        file_put_contents($archivo, $mensaje, FILE_APPEND);
    }
}
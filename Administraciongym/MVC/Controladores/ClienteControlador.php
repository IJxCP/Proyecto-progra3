<?php
require_once 'MVC/Modelo/RegistroClienteM.php';

class ClienteControlador {
    public function index() {
        $modelo = new RegistroClienteM();
        $clientes = $modelo->BuscarTodos();

        // Incluir directamente la vista con la ruta completa
        include 'MVC/Vista/Cliente/index.php';
    }

    public function crear() {
        include 'MVC/Vista/Cliente/crear.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelo = new RegistroClienteM();

            // Crear primero los datos personales
            require_once 'MVC/Modelo/DatosPersonalesM.php';
            $datosPersonalesM = new DatosPersonalesM();

            $datosPersonales = new DatosPersonales();
            $datosPersonales->setNombre($_POST['nombre']);
            $datosPersonales->setApellido1($_POST['apellido1']);
            $datosPersonales->setApellido2(isset($_POST['apellido2']) ? $_POST['apellido2'] : '');
            $datosPersonales->setFechaNacimiento($_POST['fecha_nacimiento']);
            $datosPersonales->setTelefono($_POST['telefono']);
            $datosPersonales->setCorreo($_POST['correo']);
            $datosPersonales->setDireccion($_POST['direccion']);

            $resultadoDatos = $datosPersonalesM->Insertar($datosPersonales);

            // Crear información médica básica
            require_once 'MVC/Modelo/MaterialMedicoM.php';
            $materialMedicoM = new MaterialMedicoM();

            $materialMedico = new MaterialMedico();
            $materialMedico->setAltura(0); // Valores por defecto que se actualizarán luego
            $materialMedico->setPeso(0);
            $materialMedico->setCondicionesMedicas('');
            $materialMedico->setAlergias('');
            $materialMedico->setMedicamentos('');
            $materialMedico->setPresionArterial('');
            $materialMedico->setFrecuenciaCardiaca(0);

            $resultadoMaterial = $materialMedicoM->Insertar($materialMedico);

            // Ahora crear el registro del cliente
            $registroCliente = new RegistroCliente();
            $registroCliente->setIdDatosPersonales($datosPersonales->getId());
            $registroCliente->setIdMaterialMedico($materialMedico->getId());
            $registroCliente->setFechaRegistro(date('Y-m-d'));

            // Procesar los objetivos
            if (isset($_POST['objetivos']) && $_POST['objetivos'] === 'otro' && !empty($_POST['otro_objetivo'])) {
                $registroCliente->setObjetivos($_POST['otro_objetivo']);
            } else {
                $registroCliente->setObjetivos($_POST['objetivos'] ?? '');
            }

            $registroCliente->setNotas(isset($_POST['notas']) ? $_POST['notas'] : '');

            $modelo->Insertar($registroCliente);

            // Añadir mensaje de éxito
            $_SESSION['mensaje'] = "Cliente guardado con éxito";
            $_SESSION['tipo_mensaje'] = "success";

            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $modelo = new RegistroClienteM();
            $cliente = $modelo->BuscarClienteCompleto($_GET['id']);
            include 'MVC/Vista/Cliente/editar.php';
        } else {
            $_SESSION['mensaje'] = "ID de cliente no especificado";
            $_SESSION['tipo_mensaje'] = "danger";
            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $modelo = new RegistroClienteM();

            // Actualizar datos personales
            require_once 'MVC/Modelo/DatosPersonalesM.php';
            $datosPersonalesM = new DatosPersonalesM();

            $datosPersonales = new DatosPersonales();
            $datosPersonales->setId($_POST['id_datos_personales']);
            $datosPersonales->setNombre($_POST['nombre']);
            $datosPersonales->setApellido1($_POST['apellido1']);
            $datosPersonales->setApellido2(isset($_POST['apellido2']) ? $_POST['apellido2'] : '');
            $datosPersonales->setFechaNacimiento($_POST['fecha_nacimiento']);
            $datosPersonales->setTelefono($_POST['telefono']);
            $datosPersonales->setCorreo($_POST['correo']);
            $datosPersonales->setDireccion($_POST['direccion']);

            $resultadoDatos = $datosPersonalesM->Actualizar($datosPersonales);

            // Actualizar el registro del cliente
            $registroCliente = new RegistroCliente();
            $registroCliente->setId($_POST['id']);
            $registroCliente->setIdDatosPersonales($_POST['id_datos_personales']);
            $registroCliente->setIdMaterialMedico($_POST['id_material_medico']);
            $registroCliente->setFechaRegistro($_POST['fecha_registro']);

            // Procesar los objetivos
            if ($_POST['objetivos'] === 'otro' && !empty($_POST['otro_objetivo'])) {
                $registroCliente->setObjetivos($_POST['otro_objetivo']);
            } else {
                $registroCliente->setObjetivos($_POST['objetivos']);
            }

            $registroCliente->setNotas(isset($_POST['notas']) ? $_POST['notas'] : '');

            $modelo->Actualizar($registroCliente);

            $_SESSION['mensaje'] = "Cliente actualizado con éxito";
            $_SESSION['tipo_mensaje'] = "success";

            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $modelo = new RegistroClienteM();
            $modelo->Eliminar($_GET['id']);

            $_SESSION['mensaje'] = "Cliente eliminado con éxito";
            $_SESSION['tipo_mensaje'] = "success";

            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        } else {
            $_SESSION['mensaje'] = "ID de cliente no especificado";
            $_SESSION['tipo_mensaje'] = "danger";
            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        }
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $modelo = new RegistroClienteM();
            $cliente = $modelo->BuscarClienteCompleto($_GET['id']);
            include 'MVC/Vista/Cliente/ver.php';
        } else {
            $_SESSION['mensaje'] = "ID de cliente no especificado";
            $_SESSION['tipo_mensaje'] = "danger";
            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        }
    }
}
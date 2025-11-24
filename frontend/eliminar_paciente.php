<?php
// eliminar_paciente.php
// Script que recibe la cédula por GET y ejecuta eliminarPaciente vía SOAP.
// Después redirige a listar_pacientes.php con un mensaje de resultado.
session_start();

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
    try {
        // Incluir la lógica del backend directamente
        require_once '../backend-soap/funcionesPacientes.php';

        // Instanciar el servicio
        $service = new PacienteService();

        $result = $service->eliminarPaciente($cedula);

        if ($result) {
            $_SESSION['message'] = 'Paciente eliminado exitosamente.';
            $_SESSION['messageClass'] = 'success';
        } else {
            $_SESSION['message'] = 'Error: Paciente no encontrado o no se pudo eliminar.';
            $_SESSION['messageClass'] = 'error';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
        $_SESSION['messageClass'] = 'error';
    }
} else {
    $_SESSION['message'] = 'Cédula no proporcionada.';
    $_SESSION['messageClass'] = 'error';
}

header('Location: listar_pacientes.php');
exit;
?>
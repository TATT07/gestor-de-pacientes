<?php
// crear_paciente.php
// Formulario para registrar un nuevo paciente.
// Envía los datos al servidor SOAP utilizando SoapClient para consumir registrarPaciente.
// Muestra mensajes de éxito o error.
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Incluir la lógica del backend directamente
        require_once '../backend-soap/funcionesPacientes.php';

        // Instanciar el servicio
        $service = new PacienteService();

        // Preparar el array del paciente desde el formulario
        $paciente = [
            'cedula' => $_POST['cedula'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'telefono' => $_POST['telefono'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento']
        ];

        // Llamar al método registrarPaciente directamente
        $result = $service->registrarPaciente($paciente);

        if ($result) {
            $message = 'Paciente registrado exitosamente.';
            $messageClass = 'success';
        } else {
            $message = 'Error: La cédula ya existe o hubo un problema.';
            $messageClass = 'error';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageClass = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente - GINPAC-SOAP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Paciente</h1>
        <?php if ($message): ?>
            <div class="message <?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" required>
            </div>
            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <button type="submit">Guardar</button>
        </form>
        <a href="index.php" class="back-link">Volver al Menú</a>
    </div>
</body>
</html>
<?php
// buscar_paciente.php
// Página para buscar un paciente por cédula.
// Formulario con campo cédula, al enviar consume buscarPaciente y muestra los datos o "no encontrado".
$message = '';
$paciente = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
    try {
        // Incluir la lógica del backend directamente
        require_once '../backend-soap/funcionesPacientes.php';

        // Instanciar el servicio
        $service = new PacienteService();

        $paciente = $service->buscarPaciente($cedula);

        if (!$paciente) {
            $message = 'Paciente no encontrado.';
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
    <title>Buscar Paciente - GINPAC-SOAP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Buscar Paciente</h1>
        <form method="POST">
            <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" required>
            </div>
            <button type="submit">Buscar</button>
        </form>
        <?php if ($message): ?>
            <div class="message <?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($paciente): ?>
            <h2>Datos del Paciente</h2>
            <table>
                <tr>
                    <th>Cédula</th>
                    <td><?php echo htmlspecialchars($paciente['cedula']); ?></td>
                </tr>
                <tr>
                    <th>Nombres</th>
                    <td><?php echo htmlspecialchars($paciente['nombres']); ?></td>
                </tr>
                <tr>
                    <th>Apellidos</th>
                    <td><?php echo htmlspecialchars($paciente['apellidos']); ?></td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td><?php echo htmlspecialchars($paciente['telefono']); ?></td>
                </tr>
                <tr>
                    <th>Fecha de Nacimiento</th>
                    <td><?php echo htmlspecialchars($paciente['fecha_nacimiento']); ?></td>
                </tr>
            </table>
        <?php endif; ?>
        <a href="index.php" class="back-link">Volver al Menú</a>
    </div>
</body>
</html>
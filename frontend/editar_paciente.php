<?php
// editar_paciente.php
// Página para editar un paciente existente.
// Recibe la cédula por GET, consume buscarPaciente para cargar datos.
// Muestra formulario pre-llenado, al guardar consume actualizarPaciente.
$message = '';
$paciente = null;

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
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
} else {
    header('Location: listar_pacientes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $paciente) {
    try {
        // Incluir la lógica del backend directamente
        require_once '../backend-soap/funcionesPacientes.php';

        // Instanciar el servicio
        $service = new PacienteService();

        $pacienteActualizado = [
            'cedula' => $_POST['cedula'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'telefono' => $_POST['telefono'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento']
        ];

        $result = $service->actualizarPaciente($pacienteActualizado);

        if ($result) {
            $message = 'Paciente actualizado exitosamente.';
            $messageClass = 'success';
            // Recargar datos
            $paciente = $pacienteActualizado;
        } else {
            $message = 'Error al actualizar el paciente.';
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
    <title>Editar Paciente - GINPAC-SOAP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Paciente</h1>
        <?php if ($message): ?>
            <div class="message <?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($paciente): ?>
            <form method="POST">
                <div class="form-group">
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" value="<?php echo htmlspecialchars($paciente['cedula']); ?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($paciente['nombres']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($paciente['apellidos']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($paciente['telefono']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($paciente['fecha_nacimiento']); ?>" required>
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        <?php else: ?>
            <p>Paciente no encontrado.</p>
        <?php endif; ?>
        <a href="listar_pacientes.php" class="back-link">Volver a la Lista</a>
    </div>
</body>
</html>
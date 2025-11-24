<?php
session_start();
// listar_pacientes.php
// Página que muestra una tabla con todos los pacientes.
// Consume listarPacientes del servicio SOAP para obtener la lista.
// Cada fila tiene botones Editar (enlace a editar_paciente.php) y Eliminar (confirmación JS y redirección a eliminar_paciente.php).
$message = '';
$messageClass = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageClass = $_SESSION['messageClass'];
    unset($_SESSION['message']);
    unset($_SESSION['messageClass']);
}
try {
    // Incluir la lógica del backend directamente
    require_once '../backend-soap/funcionesPacientes.php';

    // Instanciar el servicio
    $service = new PacienteService();

    // Llamar a listarPacientes directamente
    $pacientes = $service->listarPacientes();
} catch (Exception $e) {
    $pacientes = [];
    $error = 'Error al cargar pacientes: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pacientes - GINPAC-SOAP</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function confirmarEliminar(cedula) {
            if (confirm('¿Está seguro de que desea eliminar este paciente?')) {
                window.location.href = 'eliminar_paciente.php?cedula=' + cedula;
            }
        }
    </script>
</head>
<body>
    <div class="container list-container">
        <h1>Lista de Pacientes</h1>
        <?php if ($message): ?>
            <div class="message <?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pacientes)): ?>
                    <?php foreach ($pacientes as $paciente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($paciente['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['nombres']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['fecha_nacimiento']); ?></td>
                            <td class="action-buttons">
                                <a href="editar_paciente.php?cedula=<?php echo urlencode($paciente['cedula']); ?>" class="edit-btn">Editar</a>
                                <button onclick="confirmarEliminar('<?php echo $paciente['cedula']; ?>')" class="delete-btn">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay pacientes registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="index.php" class="back-link">Volver al Menú</a>
    </div>
</body>
</html>
<?php
// index.php
// Página principal del frontend, menú de navegación para el sistema GINPAC-SOAP.
// Proporciona enlaces a las funciones principales: registrar, ver, buscar pacientes.
// Incluye el CSS para el estilo moderno con glassmorphism y diseño profesional.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GINPAC-SOAP - Gestor Interno de Pacientes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <div class="logo">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C13.1046 2 14 2.89543 14 4V6H16C17.1046 6 18 6.89543 18 8V10C18 11.1046 17.1046 12 16 12H14V14C14 15.1046 13.1046 16 12 16C10.8954 16 10 15.1046 10 14V12H8C6.89543 12 6 11.1046 6 10V8C6 6.89543 6.89543 6 8 6H10V4C10 2.89543 10.8954 2 12 2Z" fill="#007bff"/>
                <path d="M8 18H16V20H8V18Z" fill="#007bff"/>
            </svg>
        </div>
        <h1>GINPAC-SOAP</h1>
        <h2>Gestor Interno de Pacientes</h2>
        <div class="menu">
            <a href="crear_paciente.php" class="menu-btn">
                <span class="icon">👨‍⚕️</span>
                <span class="text">Registrar Paciente</span>
            </a>
            <a href="listar_pacientes.php" class="menu-btn">
                <span class="icon">📋</span>
                <span class="text">Ver Pacientes</span>
            </a>
            <a href="buscar_paciente.php" class="menu-btn">
                <span class="icon">🔍</span>
                <span class="text">Buscar Paciente</span>
            </a>
            <a href="#" onclick="window.close()" class="menu-btn exit">
                <span class="icon">🚪</span>
                <span class="text">Salir</span>
            </a>
        </div>
    </div>
</body>
</html>
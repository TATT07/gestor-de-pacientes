<?php
// servidor.php
// Este archivo carga el WSDL y publica el servicio SOAP utilizando SoapServer.
// Implementa la clase PacienteService que contiene la lógica de negocio.
// El servidor SOAP maneja las solicitudes entrantes y las dirige a los métodos correspondientes.

require_once 'funcionesPacientes.php'; // Incluir el archivo con la lógica de pacientes

// Crear una instancia del servidor SOAP
// Se carga el archivo WSDL que define las operaciones y tipos de datos
$server = new SoapServer('pacientes.wsdl', [
    'uri' => 'http://localhost/backend-soap/servidor.php' // URI del servicio
]);

// Establecer la clase que implementa los métodos del servicio
// PacienteService contiene todos los métodos definidos en el WSDL
$server->setClass('PacienteService');

// Manejar la solicitud SOAP entrante
// Este método procesa la solicitud y ejecuta la operación correspondiente
$server->handle();
?>
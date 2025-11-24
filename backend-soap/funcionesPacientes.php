<?php
// funcionesPacientes.php
// Este archivo contiene la lógica real para manejar las operaciones CRUD sobre el archivo pacientes.xml
// Utiliza DOMDocument para manipular el XML de manera persistente.
// Las funciones retornan arrays asociativos que SOAP puede convertir automáticamente.

class PacienteService {

    private $xmlFile = __DIR__ . '/pacientes.xml'; // Ruta absoluta al archivo XML

    // Función para registrar un nuevo paciente
    // Recibe un objeto paciente (array asociativo) y lo agrega como un nuevo nodo en el XML
    // Retorna true si se registra exitosamente, false si ya existe o hay error
    public function registrarPaciente($paciente) {
        $dom = new DOMDocument();
        $dom->load($this->xmlFile);

        // Verificar si ya existe un paciente con la misma cédula
        $xpath = new DOMXPath($dom);
        $existing = $xpath->query("//paciente[cedula='" . $paciente['cedula'] . "']");
        if ($existing->length > 0) {
            return false; // Ya existe
        }

        // Crear nuevo nodo paciente
        $pacienteNode = $dom->createElement('paciente');
        $pacienteNode->appendChild($dom->createElement('cedula', $paciente['cedula']));
        $pacienteNode->appendChild($dom->createElement('nombres', $paciente['nombres']));
        $pacienteNode->appendChild($dom->createElement('apellidos', $paciente['apellidos']));
        $pacienteNode->appendChild($dom->createElement('telefono', $paciente['telefono']));
        $pacienteNode->appendChild($dom->createElement('fecha_nacimiento', $paciente['fecha_nacimiento']));

        $dom->documentElement->appendChild($pacienteNode);
        $dom->save($this->xmlFile);
        return true;
    }

    // Función para buscar un paciente por cédula
    // Recibe la cédula y retorna el paciente como array asociativo o null si no existe
    public function buscarPaciente($cedula) {
        $dom = new DOMDocument();
        $dom->load($this->xmlFile);

        $xpath = new DOMXPath($dom);
        $pacienteNode = $xpath->query("//paciente[cedula='" . $cedula . "']")->item(0);

        if ($pacienteNode) {
            return [
                'cedula' => $pacienteNode->getElementsByTagName('cedula')->item(0)->nodeValue,
                'nombres' => $pacienteNode->getElementsByTagName('nombres')->item(0)->nodeValue,
                'apellidos' => $pacienteNode->getElementsByTagName('apellidos')->item(0)->nodeValue,
                'telefono' => $pacienteNode->getElementsByTagName('telefono')->item(0)->nodeValue,
                'fecha_nacimiento' => $pacienteNode->getElementsByTagName('fecha_nacimiento')->item(0)->nodeValue,
            ];
        }
        return null;
    }

    // Función para listar todos los pacientes
    // Retorna un array de arrays asociativos con todos los pacientes
    public function listarPacientes() {
        $dom = new DOMDocument();
        $dom->load($this->xmlFile);

        $pacientes = [];
        $pacienteNodes = $dom->getElementsByTagName('paciente');

        foreach ($pacienteNodes as $node) {
            $pacientes[] = [
                'cedula' => $node->getElementsByTagName('cedula')->item(0)->nodeValue,
                'nombres' => $node->getElementsByTagName('nombres')->item(0)->nodeValue,
                'apellidos' => $node->getElementsByTagName('apellidos')->item(0)->nodeValue,
                'telefono' => $node->getElementsByTagName('telefono')->item(0)->nodeValue,
                'fecha_nacimiento' => $node->getElementsByTagName('fecha_nacimiento')->item(0)->nodeValue,
            ];
        }
        return $pacientes;
    }

    // Función para actualizar un paciente existente
    // Recibe el paciente actualizado (array asociativo) y actualiza el nodo correspondiente por cédula
    // Retorna true si se actualiza, false si no existe
    public function actualizarPaciente($pacienteActualizado) {
        $dom = new DOMDocument();
        $dom->load($this->xmlFile);

        $xpath = new DOMXPath($dom);
        $pacienteNode = $xpath->query("//paciente[cedula='" . $pacienteActualizado['cedula'] . "']")->item(0);

        if ($pacienteNode) {
            $pacienteNode->getElementsByTagName('nombres')->item(0)->nodeValue = $pacienteActualizado['nombres'];
            $pacienteNode->getElementsByTagName('apellidos')->item(0)->nodeValue = $pacienteActualizado['apellidos'];
            $pacienteNode->getElementsByTagName('telefono')->item(0)->nodeValue = $pacienteActualizado['telefono'];
            $pacienteNode->getElementsByTagName('fecha_nacimiento')->item(0)->nodeValue = $pacienteActualizado['fecha_nacimiento'];

            $dom->save($this->xmlFile);
            return true;
        }
        return false;
    }

    // Función para eliminar un paciente por cédula
    // Recibe la cédula y elimina el nodo correspondiente
    // Retorna true si se elimina, false si no existe
    public function eliminarPaciente($cedula) {
        $dom = new DOMDocument();
        $dom->load($this->xmlFile);

        $xpath = new DOMXPath($dom);
        $pacienteNode = $xpath->query("//paciente[cedula='" . $cedula . "']")->item(0);

        if ($pacienteNode) {
            $pacienteNode->parentNode->removeChild($pacienteNode);
            $dom->save($this->xmlFile);
            return true;
        }
        return false;
    }
}
?>
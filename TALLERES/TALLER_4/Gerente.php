<?php
// Incluir la interfaz Evaluable
require_once 'Evaluable.php';

// Definición de la clase Gerente que extiende de Empleado e implementa Evaluable
class Gerente extends Empleado implements Evaluable {

    // Propiedades específicas de la clase Gerente
    public $bono;           // Bono asignado al gerente
    public $departamento;   // Departamento que gestiona el gerente 

    // Constructor de la clase Gerente
    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento, $bono) {
        // Llamada al constructor de la clase base Empleado
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        // Inicialización de propiedades específicas
        $this->departamento = trim($departamento);
        $this->bono = trim($bono);
    }

    // Método para obtener el bono
    public function getBono() {
        return $this->bono;
    }

    // Método para obtener el departamento
    public function getDepartamento() {
        return $this->departamento;
    }
   
    // Método para establecer el bono
    public function setBono($bono) {
        $this->bono = trim($bono);
    }

    // Método para establecer el departamento
    public function setDepartamento($departamento) {
        $this->departamento = trim($departamento);
    }

    // Implementación del método evaluarDesempenio de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Obtiene el bono actual
        $bono = $this->getBono();
        
        // Evaluación del desempeño basada en el valor del bono
        switch ($bono) {
            case 200:
                return "El gerente " . $this->nombre . " del departamento " . $this->departamento . " tiene un desempeño excepcional. Bono asignado: $bono.";
            case 150:
                return "El gerente " . $this->nombre . " del departamento " . $this->departamento . " tiene un desempeño sobresaliente. Bono asignado: $bono.";
            case 100:
                return "El gerente " . $this->nombre . " del departamento " . $this->departamento . " tiene un desempeño muy bueno. Bono asignado: $bono.";
            case 50:
                return "El gerente " . $this->nombre . " del departamento " . $this->departamento . " tiene un desempeño aceptable. Bono asignado: $bono.";
            case 0:
                return "El gerente " . $this->nombre . " del departamento " . $this->departamento . " necesita mejorar. No se asigna bono.";
            default:
                return "El gerente " . $this->nombre . " del departamento " . $this->departamento . " tiene un desempeño insatisfactorio. No se asigna bono.";
        }
    }
}
?>

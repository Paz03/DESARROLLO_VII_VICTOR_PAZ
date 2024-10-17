<?php
// Incluir la interfaz Evaluable para implementar evaluaciones de desempeño
require_once 'Evaluable.php';

// Clase Desarrollador que hereda de Empleado e implementa la interfaz Evaluable
class Desarrollador extends Empleado implements Evaluable {

    // Propiedades específicas del desarrollador
    public $lenguajePrincipal;  // Almacena el lenguaje de programación principal del desarrollador
    public $nivelExperiencia;   // Almacena el nivel de experiencia del desarrollador (junior, mid, senior)

    // Constructor de la clase Desarrollador
    public function __construct($nombre, $idEmpleado, $salarioBase, $lenguajePrincipal, $nivelExperiencia) {
        parent::__construct($nombre, $idEmpleado, $salarioBase); // Llama al constructor de la clase padre (Empleado)
        $this->lenguajePrincipal = trim($lenguajePrincipal); // Inicializa el lenguaje principal
        $this->setNivelExperiencia($nivelExperiencia); // Inicializa el nivel de experiencia
    }

    // Método para obtener el lenguaje principal del desarrollador
    public function getLenguajePrincipal() {
        return $this->lenguajePrincipal;
    }

    // Método para obtener el nivel de experiencia del desarrollador
    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }
   
    // Método para establecer el lenguaje principal del desarrollador
    public function setLenguajePrincipal($lenguaje) {
        $this->lenguajePrincipal = trim($lenguaje); // Establece el lenguaje principal
    }

    // Método para establecer el nivel de experiencia del desarrollador
    public function setNivelExperiencia($nivel) {
        $this->nivelExperiencia = trim($nivel); // Establece el nivel de experiencia
    }

    // Método para evaluar el desempeño del desarrollador
    public function evaluarDesempenio() {
        // Se evalúa el desempeño según el nivel de experiencia
        switch (strtolower($this->getNivelExperiencia())) {
            case 'junior':
                return "El desarrollador " . $this->nombre . " es un programador junior en " . $this->lenguajePrincipal . ".";
            case 'mid':
                return "El desarrollador " . $this->nombre . " tiene experiencia intermedia en " . $this->lenguajePrincipal . ".";
            case 'senior':
                return "El desarrollador " . $this->nombre . " es un programador senior en " . $this->lenguajePrincipal . ".";
            default:
                return "El nivel de experiencia del desarrollador " . $this->nombre . " en " . $this->lenguajePrincipal . " no es reconocido.";
        }
    }
}
?>

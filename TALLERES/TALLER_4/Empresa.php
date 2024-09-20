<?php 

// Incluir las clases necesarias
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';

// Definición de la clase Empresa
class Empresa {
    // Propiedad privada que almacena los empleados de la empresa
    private $empleados = [];

    // Método para agregar un empleado a la lista
    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado; // Añade el empleado al arreglo
    }

    // Método para listar todos los empleados
    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            // Muestra el nombre, ID y salario de cada empleado
            echo "Nombre: " . $empleado->getNombre() . ", ID: " . $empleado->getIdEmpleado() . ", Salario: " . $empleado->getSalarioBase() . "<br>";
        }
    }

    // Método para calcular la nómina total de la empresa
    public function calcularNominaTotal() {
        $total = 0; // Inicializa el total a 0
        foreach ($this->empleados as $empleado) {
            $total += $empleado->getSalarioBase(); // Suma el salario de cada empleado al total
        }
        return $total; // Devuelve el total de la nómina
    }

    // Método para realizar evaluaciones de desempeño
    public function realizarEvaluaciones() {
        foreach ($this->empleados as $empleado) {
            // Verifica si el empleado implementa la interfaz Evaluable
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio() . "\n"; // Llama al método de evaluación
            } else {
                // Mensaje si el empleado no es evaluable
                echo "El empleado " . $empleado->getNombre() . " no puede ser evaluado, ya que no implementa la interfaz Evaluable.\n";
            }
        }
    }
}
?>

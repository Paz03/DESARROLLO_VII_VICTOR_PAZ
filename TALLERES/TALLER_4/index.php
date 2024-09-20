<?php

// Incluir archivos de clases necesarias
require_once 'Empleado.php';      // Incluye la clase base Empleado
require_once 'Gerente.php';       // Incluye la clase Gerente que hereda de Empleado
require_once 'Desarrollador.php';  // Incluye la clase Desarrollador que hereda de Empleado
require_once 'Empresa.php';        // Incluye la clase Empresa para gestionar empleados

// Crear instancias de empleados
$gerente1 = new Gerente("Juan Pérez", "G001", 5000, "Recursos Humanos", 100); // Instancia de Gerente
$desarrollador1 = new Desarrollador("Ana López", "D001", 3000, "PHP", "Senior"); // Instancia de Desarrollador
$desarrollador2 = new Desarrollador("Luis Martínez", "D002", 2500, "JavaScript", "Mid"); // Otra instancia de Desarrollador

// Crear una instancia de la empresa
$empresa = new Empresa(); // Se crea un objeto Empresa

// Agregar empleados a la empresa
$empresa->agregarEmpleado($gerente1);       // Agrega el gerente a la empresa
$empresa->agregarEmpleado($desarrollador1);  // Agrega el primer desarrollador a la empresa
$empresa->agregarEmpleado($desarrollador2);  // Agrega el segundo desarrollador a la empresa

// Listar empleados
echo "Lista de Empleados:<br>"; // Mensaje para indicar que se listarán los empleados
$empresa->listarEmpleados();    // Llama al método para listar todos los empleados
echo "\n"; // Nueva línea para mejorar la legibilidad

// Calcular y mostrar la nómina total
$nominaTotal = $empresa->calcularNominaTotal(); // Llama al método para calcular la nómina total
echo "Nómina Total: $" . $nominaTotal . "<br>"; // Muestra la nómina total calculada

// Evaluaciones de Desempeño
echo "Evaluaciones de Desempeño:<br>"; // Mensaje para indicar que se realizarán evaluaciones
$empresa->realizarEvaluaciones(); // Llama al método para realizar evaluaciones de desempeño

?>

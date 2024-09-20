<?php

// Definición de la clase Empleado
class Empleado {
    // Propiedades públicas para almacenar la información del empleado
    public $nombre;        // Nombre del empleado
    public $idEmpleado;    // ID único del empleado
    public $salarioBase;   // Salario base del empleado

    // Constructor para inicializar las propiedades del empleado
    public function __construct($nombre, $idEmpleado, $salarioBase) {
        $this->nombre = trim($nombre);           // Asigna el nombre, eliminando espacios en blanco
        $this->idEmpleado = trim($idEmpleado);   // Asigna el ID del empleado, eliminando espacios en blanco
        $this->salarioBase = trim($salarioBase); // Asigna el salario base, eliminando espacios en blanco
    }

    // Método getter para obtener el nombre del empleado
    public function getNombre() {
        return $this->nombre;
    }

    // Método getter para obtener el ID del empleado
    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    // Método getter para obtener el salario base del empleado
    public function getSalarioBase() {
        return $this->salarioBase;
    }

    // Método setter para establecer el salario base del empleado
    public function setSalarioBase($salarioBase) {
        $this->salarioBase = trim($salarioBase); // Asigna el salario base, eliminando espacios en blanco
    }

    // Método setter para establecer el nombre del empleado
    public function setNombre($nombre) {
        $this->nombre = trim($nombre); // Asigna el nombre, eliminando espacios en blanco
    }

    // Método setter para establecer el ID del empleado
    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = trim($idEmpleado); // Asigna el ID del empleado, eliminando espacios en blanco
    }

}
?>

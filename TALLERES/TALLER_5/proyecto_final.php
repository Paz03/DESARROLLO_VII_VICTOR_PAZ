<?php

class Estudiante {
    private $id;
    private $nombre;
    private $edad;
    private $carrera;
    private $materias; // Arreglo asociativo con materias y calificaciones

    public function __construct($id, $nombre, $edad, $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = [];
    }

    public function getid() {
        return $this->id;
    }

    public function getCarrera() {
        return $this->carrera; // Método para acceder a la carrera

        
    }
    public function getNombre() {
        return $this->nombre; // Método para acceder al nombre
    }

    public function agregarMateria($materia, $calificacion) {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerMaterias() {
        return $this->materias;
    }

    public function obtenerPromedio() {
        return count($this->materias) > 0 ? array_sum($this->materias) / count($this->materias) : 0;
    }

    public function obtenerDetalles() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => implode(", ", array_map(function($k, $v) { return "$k: $v"; }, array_keys($this->materias), $this->materias)), // Formatear materias como cadena
            'promedio' => $this->obtenerPromedio()
        ];
    }
}

class SistemaGestionEstudiantes {
    private $estudiantes;

    public function __construct() {
        $this->estudiantes = [];
    }

    public function agregarEstudiante(Estudiante $estudiante) {
        $this->estudiantes[$estudiante->getid()] = $estudiante;
    }

    public function obtenerEstudiante($id) {
        return $this->estudiantes[$id] ?? null;
    }

    public function listarEstudiantes() {
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral() {
        if (empty($this->estudiantes)) return 0;
        $promedios = array_map(function($estudiante) {
            return $estudiante->obtenerPromedio();
        }, $this->estudiantes);
        return array_sum($promedios) / count($promedios);
    }

    public function obtenerEstudiantesPorCarrera($carrera) {
        return array_filter($this->estudiantes, function($estudiante) use ($carrera) {
            return strtolower($estudiante->getCarrera()) === strtolower($carrera); // Usar el método getCarrera
        });
    }

    public function obtenerMejorEstudiante() {
        return array_reduce($this->estudiantes, function($mejor, $estudiante) {
            return ($mejor === null || $estudiante->obtenerPromedio() > $mejor->obtenerPromedio()) ? $estudiante : $mejor;
        });
    }

    public function generarReporteRendimiento() {
        $reporte = [];
        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->obtenerMaterias() as $materia => $calificacion) {
                if (!isset($reporte[$materia])) {
                    $report[$materia] = ['total' => 0, 'count' => 0, 'max' => $calificacion, 'min' => $calificacion];
                }
                $report[$materia]['total'] += $calificacion;
                $report[$materia]['count']++;
                $report[$materia]['max'] = max($report[$materia]['max'], $calificacion);
                $report[$materia]['min'] = min($report[$materia]['min'], $calificacion);
            }
        }

        foreach ($reporte as $materia => &$data) {
            $data['promedio'] = $data['total'] / $data['count'];
        }

        return $reporte;
    }
    public function evaluarEstadosAcademicos() {
        $resultados = [];
        foreach ($this->estudiantes as $estudiante) {
            $promedio = $estudiante->obtenerPromedio();
            if ($promedio > 61 && $promedio < 71) {
                $estado = "Riesgo académico";
            } elseif ($promedio >= 72 && $promedio <= 81) {
                $estado = "Buenas calificaciones";
            } elseif ($promedio > 81) {
                $estado = "Honor roll";
            } else {
                $estado = "Fracaso";
            }
            $resultados[$estudiante->getNombre()] = $estado;
        }
        return $resultados;
    }
  

    public function generarRanking() {
        usort($this->estudiantes, function($a, $b) {
            return $b->obtenerPromedio() <=> $a->obtenerPromedio();
        });
        return array_map(function($estudiante) {
            return [
                'nombre' => $estudiante->getNombre(), 
                'promedio' => $estudiante->obtenerPromedio()
            ];
        }, $this->estudiantes);
    }

    public function buscarEstudiantes($Lista) {
        return array_filter($this->estudiantes, function($estudiante) use ($Lista) {
            return stripos($estudiante->getNombre(), $Lista) !== false || stripos($estudiante->getCarrera(), $Lista) !== false; // Usar getNombre
        });
    }
    public function estadisticasPorCarrera($carrera) {
        $estudiantesCarrera = $this->obtenerEstudiantesPorCarrera($carrera);
        $totalEstudiantes = count($estudiantesCarrera);
        if ($totalEstudiantes === 0) return null; // Manejo de caso sin estudiantes
        $promedioGeneral = array_reduce($estudiantesCarrera, function($carry, $estudiante) {
            return $carry + $estudiante->obtenerPromedio();
        }, 0) / $totalEstudiantes;
        $mejorEstudiante = $this->obtenerMejorEstudiante();

        return [
            'total_estudiantes' => $totalEstudiantes,
            'promedio_general' => $promedioGeneral,
            'mejor_estudiante' => $mejorEstudiante ? $mejorEstudiante->obtenerDetalles() : null
        ];
    }
}

// Sección de prueba
$sistema = new SistemaGestionEstudiantes();

// Crear estudiantes
$estudiantes = [
    new Estudiante(1, 'Juan Pérez', 20, 'Ingeniería'),
    new Estudiante(2, 'María López', 22, 'Medicina'),
    new Estudiante(3, 'Carlos Sánchez', 21, 'Arquitectura'),
    new Estudiante(4, 'Ana Torres', 23, 'Ingeniería'),
    new Estudiante(5, 'Luis González', 19, 'Medicina'),
    new Estudiante(6, 'Laura Martínez', 22, 'Arquitectura'),
    new Estudiante(7, 'Jorge Díaz', 20, 'Ingeniería'),
    new Estudiante(8, 'Sofia Ruiz', 21, 'Medicina'),
    new Estudiante(9, 'Pedro Fernández', 24, 'Arquitectura'),
    new Estudiante(10, 'Clara Moreno', 22, 'Ingeniería'),
];

// Asignar materias y calificaciones
$materias = [
    'Ingles' => [90, 15, 78, 88, 12, 80, 16, 95, 89, 91],
    'Calculo' => [85, 90, 95, 80, 75, 88, 82, 12, 78, 84],
    'Fisca' => [88, 76, 90, 12, 85, 78, 80, 89, 91, 87],
];

foreach ($estudiantes as $index => $estudiante) {
    foreach ($materias as $materia => $calificaciones) {
        $estudiante->agregarMateria($materia, $calificaciones[$index]);
    }
    $sistema->agregarEstudiante($estudiante);
}

// Ejemplo de uso
echo "Lista de estudiantes:<br>";
foreach ($sistema->listarEstudiantes() as $estudiante) {
    $detalles = $estudiante->obtenerDetalles();
    echo implode(", ", $detalles) . "<br>";
}

echo "<br>Promedio general: " . $sistema->calcularPromedioGeneral() . "<br>";

$mejorEstudiante = $sistema->obtenerMejorEstudiante();
echo "Mejor estudiante: " . ($mejorEstudiante ? implode(", ", $mejorEstudiante->obtenerDetalles()) . "<br>" : "No hay estudiantes.<br>");

/// Generar reporte de rendimiento
echo "\nReporte de rendimiento:<br>";
$reporte = $sistema->generarReporteRendimiento();
foreach ($reporte as $materia => $datos) {
    echo $materia . ": " . implode(", ", [
        "Total: " . $datos['total'],
        "Count: " . $datos['count'],
        "Max: " . $datos['max'],
        "Min: " . $datos['min'],
        "Promedio: " . $datos['promedio']
    ]) . "<br>";
}

// Generar estadísticas por carrera
$carrera = 'Ingeniería';
echo "<br>Estadísticas para la carrera de $carrera:<br>";
$estadisticas = $sistema->estadisticasPorCarrera($carrera);
if ($estadisticas) {
    echo implode(", ", [
        "Total de estudiantes: " . $estadisticas['total_estudiantes'],
        "Promedio general: " . $estadisticas['promedio_general'],
        "Mejor estudiante: " . ($estadisticas['mejor_estudiante'] ? $estadisticas['mejor_estudiante']['nombre'] : "N/A")
    ]);
} else {
    echo "No hay estudiantes en esta carrera.";
}
echo "<br><br>";

$estados = $sistema->evaluarEstadosAcademicos();
echo "Estados académicos de todos los estudiantes:<br>";
foreach ($estados as $nombre => $estado) {
    echo "$nombre: $estado<br>";
}


echo "<br>Ranking de estudiantes:<br>";
foreach ($sistema->generarRanking() as $estudiante) {
    echo implode(", ", $estudiante) . "<br>";
}
$estudiantesBuscados = $sistema->buscarEstudiantes('María');
if (!empty($estudiantesBuscados)) {
    echo "<br>Buscar estudiantes con 'María':<br>";
    echo implode("<br>", array_map(function($estudiante) {
        return $estudiante->getNombre() . ", " . $estudiante->getid() . ", " . $estudiante->getCarrera();
    }, $estudiantesBuscados));
} else {
    echo "<br>No se encontraron estudiantes con 'María'.<br>";
}

$estudiantesBuscados = $sistema->buscarEstudiantes('Victor');
if (!empty($estudiantesBuscados)) {
    echo "<br>Buscar estudiantes con 'Victor':<br>";
    echo implode("<br>", array_map(function($estudiante) {
        return $estudiante->getNombre() . ", " . $estudiante->getid() . ", " . $estudiante->getCarrera();
    }, $estudiantesBuscados));
} else {
    echo "<br>No se encontraron estudiantes con 'Victor'.<br>";
}
?>

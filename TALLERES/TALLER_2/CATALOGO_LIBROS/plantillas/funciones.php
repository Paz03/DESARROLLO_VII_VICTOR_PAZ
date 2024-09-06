<?php
function obtenerTituloPagina($pagina) {
    $titulos = [
        'index' => 'Página de Inicio',
        'sobre_nosotros' => 'Sobre Nosotros',
        'contacto' => 'Contáctanos'
    ];
    return isset($titulos[$pagina]) ? $titulos[$pagina] : 'Catalogo de Libros';
}

function generarMenu($paginaActual) {
    $menu = [
        'index' => 'Inicio',
        'sobre_nosotros' => 'Sobre Nosotros',
        'contacto' => 'Contacto'
    ];
    
    $html = '<nav><ul>';
    foreach ($menu as $pagina => $titulo) {
        $clase = ($pagina === $paginaActual) ? ' class="activo"' : '';
        $html .= "<li><a href=\"{$pagina}.php\"{$clase}>{$titulo}</a></li>";
    }
    $html .= '</ul></nav>';
    return $html;
}
function obtenerLibros() {
    // Simulando una base de datos con un array de libros
    return [
        [
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'anio_publicacion' => 1605,
            'genero' => 'Novela',
            'descripcion' => 'La historia del ingenioso hidalgo Don Quijote de la Mancha.'
        ],
        [
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
            'anio_publicacion' => 1967,
            'genero' => 'Realismo mágico',
            'descripcion' => 'La saga de la familia Buendía en el pueblo ficticio de Macondo.'
        ],
        [
            'titulo' => '1984',
            'autor' => 'George Orwell',
            'anio_publicacion' => 1949,
            'genero' => 'Distopía',
            'descripcion' => 'Una visión del futuro totalitario y opresivo.'
        ],
        [
            'titulo' => 'El Hobbit',
            'autor' => 'J.R.R. Tolkien',
            'anio_publicacion' => 1937,
            'genero' => 'Fantasía',
            'descripcion' => 'Las aventuras de Bilbo Baggins en la Tierra Media.'
        ],
        [
            'titulo' => 'Matar a un ruiseñor',
            'autor' => 'Harper Lee',
            'anio_publicacion' => 1960,
            'genero' => 'Ficción',
            'descripcion' => 'La lucha contra la injusticia racial en el sur de los EE.UU.'
        ]
    ];
}

function mostrarDetallesLibro($libro) {
    return "
        <div class='libro'>
            <h2>{$libro['titulo']}</h2>
            <p><strong>Autor:</strong> {$libro['autor']}</p>
            <p><strong>Año de Publicación:</strong> {$libro['anio_publicacion']}</p>
            <p><strong>Género:</strong> {$libro['genero']}</p>
            <p><strong>Descripción:</strong> {$libro['descripcion']}</p>
        </div>
    ";
}
?>
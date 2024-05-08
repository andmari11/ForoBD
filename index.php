<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\foros;
use es\ucm\fdi\aw\noticias;

$titulo = 'Index';
$contenido = '';
if (($app->usuarioLogueado()) && ($app->esAdmin())) {
    $contenido .= <<<EOS
    <h2>HOME <button type="button">Editar</button></h2>
EOS;
} else {
    $contenido .= <<<EOS
    <h2>HOME</h2> 
EOS;
}

$contenido .= <<<EOS
    <div id='container'>
        <div id ='nots'>
            
EOS;


$contenido .= <<<EOS
               
        <div id ='foros'>
            <h2>Foros destacados</h2>
            
EOS;

$forosDestacados = es\ucm\fdi\aw\foros\Foro::listaDestacados(1);

if ($forosDestacados != NULL) {
    foreach ($forosDestacados as $foro) {
        $contenido .= '<div class="foro">';
        $contenido .= '<h3><a href="foroDinamico.php?id=' . $foro->getId() . '">' . $foro->getTitulo() . '</a></h3>';
        if($foro->getImagen()!=null){

            $contenido .= '<div class="foro-imagen">'; 
            $contenido .= '<img class="foro-imagen" src="data:image/jpeg;base64,'.base64_encode($foro->getImagen()).'" alt = "foro-imagen">';
            $contenido .= '</div>';
        }
        $contenido .= "<p>" . $foro->getDescripcion() . "</p>";
        $contenido .= "<p>" . $foro->getfavoritos() . "<span style='color: red;'>&#11088;&#65039;</span>" .$foro->getMensajesNum() .  "<span style='color: red;'>&#128172;</span></p>";
        $contenido .= '</div>';
    }
} else {
    $contenido .= "<p>No se encontraron foros destacados.</p>";
}

$contenido .= <<<EOS
        </div>   
    </div>
EOS;

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);
?>

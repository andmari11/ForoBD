<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\abd\foros;
use es\ucm\fdi\abd\Aplicacion;

$titulo = 'Foro';




$contenido = '';

if ($app->usuarioLogueado()) {
    
        $contenido .= <<<EOS
        <h2>FORO</h2>
        <div id = 'container-foros'>
            <div id = 'favoritos'>
                <h2>Foros favoritos</h2>
        EOS;
        
        $forosFavoritos = es\ucm\fdi\abd\foros\Foro::listaFavoritos($app->getUsuarioID());
        if ($forosFavoritos != NULL) {
            foreach ($forosFavoritos as $foro) {
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
     
        }
        else {
            $contenido .= "<p>No tienes foros favoritos.</p>";
        }

        $contenido .= <<<EOS
            
        
        </div>
        <div id ='foros'>
            <h2>Todos los foros</h2>
            
EOS;

$forosDestacados = es\ucm\fdi\abd\foros\Foro::listaForos();

if ($forosDestacados != NULL) {
    foreach ($forosDestacados as $foro) {
        $contenido .= '<div class="foro">';
        if($foro->getDestacado()){
            $contenido.="<h3>";
        }
        else{
            $contenido.="<h4>";

        }
        $contenido .= '<a href="foroDinamico.php?id=' . $foro->getId() . '">' . $foro->getTitulo() . '</a>';
        if($foro->getDestacado()){
            $contenido.="</h3>";
  
        }
        else{
            $contenido.="</h4>";

        }
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
        
    

} else {
    $contenido .= <<<EOS
                <h2>FORO</h2>
                <p>Inicie sesión para visualizar contenido exclusivo del foro: <a href='login.php'>Login</a></p>
                EOS;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);
<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\abd\mensajes\Mensaje;
use es\ucm\fdi\abd\Aplicacion;
use es\ucm\fdi\abd\mensajes\FormularioMensajeLike;
use es\ucm\fdi\abd\mensajes\FormularioMensajeEliminar;
use es\ucm\fdi\abd\usuarios\FormularioUsuarioBloquear;
use es\ucm\fdi\abd\usuarios\Usuario;




$app = Aplicacion::getInstance();

$id_usuario = $_GET['id'];

$usuario = es\ucm\fdi\abd\usuarios\Usuario::buscaUsuarioPorId($id_usuario);
$contenido = '';

if ($usuario === null) {
    $contenido.= 'No se encontró el usuario.';
    exit;
}
$titulo = $usuario->getNombre();
$contenido .= "<h2 class='titulo-usuario'> Perfil de " . $titulo . ":</h2>";
if($usuario->getImagen()!=null){

    $contenido .= '<div class="usuario-imagenes-din">'; 
    $contenido .= '<img class="imagen-usuario-din" src="data:image/jpeg;base64,'.base64_encode($usuario->getImagen()).'" alt = "usuario-imagen">';
    $contenido .= '</div>';
}
if($app->usuarioLogueado() and ($app->getUsuarioID()==$id_usuario or $app->esAdmin())){

    $contenido.= "<a href='editUsuarios.php?usuario=" . urlencode($usuario->getNombre()) . "'>" . "Editar usuario" . "</a> ";

}




$resultado = Mensaje::getMensajesUsuario($id_usuario, $app->esAdmin() or $app->esModerador());
$contenido.= <<<EOS
<div id='container-user'>
    <div id ='msg'>     
EOS;
$contenido.= "<h2> Mensajes de $titulo</h2>";
if($resultado!=null){

    foreach ($resultado as $mensaje) {
        $contenido.= "<div class ='forodin'>";
        $contenido.= "<div class ='usfeho'>";
        $imagen = '<img class="imagen-usuario-din" src="data:image/jpeg;base64,' . base64_encode( Usuario::getFotoPerfil($mensaje->getUsuarioId())) . '" alt="usuariodin">';
        $contenido.= "<p> " . $imagen . "</p>";
        $usuarioNombre=Usuario::getNombreAutor($mensaje->getUsuarioId());
        $usuarioRol=Usuario::getRolAutor($mensaje->getUsuarioId());
        if($usuarioRol == 'a' || $usuarioRol == 'm'){
            $contenido.= "<a class='usermsg-admin' href='usuarioDinamico.php?id=". urlencode($mensaje->getUsuarioId()) ."'> $usuarioNombre</a>";
        }
        else{
            $contenido.= "<a class='usermsg' href='usuarioDinamico.php?id=". urlencode($mensaje->getUsuarioId()) ."'> $usuarioNombre</a>";
        }
        $contenido.= "<p class ='fechamsg'> Fecha: " . $mensaje->getFecha() . "</p>";
        $contenido.= "<p class ='horamsg'>" . $mensaje->getHora() . "</p>";
        $contenido.= "</div>";
       
        $contenido.= "<div class ='mensaje'>";
        $contenido.= "<p>" . $mensaje->getText() . "</p>";
        if ($mensaje->getImagen() !== null) {
            $contenido .= '<img class="imagen-mensaje-din" src="data:image/jpeg;base64,'.base64_encode($mensaje->getImagen()).'" alt="mensajedin">';
        }
        $contenido.= "</div>";
    
        if($app->usuarioLogueado()){    
            $url = "usuarioDinamico.php?id=" . $id_usuario;
            $form = new FormularioMensajeLike($mensaje, $url);
            $contenido .= "<div class ='bot-msg'>" . $form->gestiona();
    
            if($app->esAdmin() or $app->esModerador()){
                $formEliminar = new FormularioMensajeEliminar($mensaje, $url);
                $contenido .= $formEliminar->gestiona();
                
                
                $formBloquear = new FormularioUsuarioBloquear($mensaje->getUsuarioId(), $url);
                $contenido .= $formBloquear->gestiona();
            }
            $contenido .= "</div>";
        
        }
        else{
            $contenido.= "<p class= 'likemsg'>" . $mensaje->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
        }
        $contenido.= "</div>";
    }
    $contenido.= "</div>";
}



$contenido .= <<<EOS
        </div>   
    </div>
EOS;


$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);


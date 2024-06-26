<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\abd\Aplicacion;
use es\ucm\fdi\abd\usuarios\FormularioUsuarioBloquear;
use es\ucm\fdi\abd\usuarios\FormularioUsuarioEliminar;
use es\ucm\fdi\abd\foros\FormularioForoEliminar;

$titulo = "Administración";
$contenido="<h2>Panel de Administración</h2>";

if($app->esAdmin()){
    $contenido .= <<<EOS
    <h3>Usuarios   <a href='anadirUsuario.php'>Añadir nuevo usuario</a></h3>
    EOS;
    $usuarios=es\ucm\fdi\abd\usuarios\Usuario::listaUsuario();
    if ($usuarios !== NULL) {
        $contenido .= "<table class='tabla-usuarios'>";
        $contenido .= "<tr><th>Id</th><th>Nombre</th><th>Imagen</th><th>Email</th><th>Rol</th><th>Editar </th><th> Eliminar </th><th> Bloquear </th></tr>";
        foreach ($usuarios as $usuario) {
            $contenido .= "<tr>";
            $contenido .= "<td>" . $usuario->getId() . "</td>";
            $nombre=$usuario->getNombre() ;
            $contenido .= "<td>" . "<a href='usuarioDinamico.php?id=". urlencode($usuario->getId()) ."'> $nombre<p class='usermsg'></p></a>" . "</td>";
            $imagen = '<img class="imagen-usuario-din" src="data:image/jpeg;base64,' . base64_encode($usuario->getImagen()) . '" alt="usuariodin">';
            $contenido .= "<td>" . $imagen . "</td>";            
            $contenido .= "<td>" . $usuario->getEmail() . "</td>";
            $contenido .= "<td>" . $usuario->getRol() . "</td>";

            if($usuario->getRol()!="a") {
                $contenido .= "<td>" ." <a href='editUsuarios.php?usuario=" . urlencode($usuario->getNombre()) . "'>✏️</a>". "</td>";
                $formDelete = new FormularioUsuarioEliminar($usuario->getNombre());
                $contenido .= "<td>" . $formDelete->gestiona(). "</td>";

                if($usuario->getRol()!="m"){

                    $formBloquear= new FormularioUsuarioBloquear($usuario->getId(), $app->resuelve('admin.php'));
                    $contenido .= "<td>" . $formBloquear->gestiona(). "</td>";
                }
                else{
                    $contenido .= "<td>"."". "</td>";

                }

            }
            else{
                $contenido .= "<td>"."". "</td>";
                $contenido .= "<td>"."". "</td>";
            }

            $contenido .= "</tr>";
        }
        $contenido .= "</table>";
    } else {
        $contenido .= "<p>No se encontraron usuarios.</p>";
    }
}



if($app->esAdmin() || $app->esModerador()){
    $contenido .= <<<EOS
    <h3>Foros
    <a href="crearForo.php">Crear foro</a></h3>
    EOS;
    $foros = \es\ucm\fdi\abd\foros\Foro::listaForos();
    if ($foros !== NULL) {
        $contenido .= "<table class='tabla-foros'>";
        $contenido .= "<tr><th>Id</th><th>Nombre</th><th>Descripción</th><th>Fecha</th><th>Favoritos</th><th>Destacado</th><th>Editar</th><th>Eliminar</th></tr>";
        foreach ($foros as $foro) {
            $contenido .= "<tr>";
            $contenido .= "<td>" . $foro->getId() . "</td>";
            $contenido .= "<td>" . "<a href='foroDinamico.php?id=" . $foro->getId() . "'>" . $foro->getTitulo() . "</a></td>";
            $contenido .= "<td>" . $foro->getDescripcion() . "</td>";
            $contenido .= "<td>" . $foro->getFecha() . "</td>";
            $contenido .= "<td>" . $foro->getFavoritos() . "</td>";
            $contenido .= "<td>" . ($foro->getDestacado() ? 'Sí' : 'No') . "</td>";
            $contenido .= "<td>" ." <a href='editarForo.php?foro=" . urlencode($foro->getId()) . "'>✏️</a>". "</td>";
            $formDelete = new FormularioForoEliminar($foro->getId());
            $contenido .= "<td>" . $formDelete->gestiona(). "</td>";
            $contenido .= "</tr>";
        }
        $contenido .= "</table>";
    } else {
        $contenido .= "<p>No se encontraron foros.</p>";
    }
}



if(!$app->esAdmin()  and !$app->esModerador()) {
    $contenido = <<<EOS
    <h1>Panel de Administración  </h1>
    <p> ACCESO DENEGADO. </p>
    EOS;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);
<?php
namespace es\ucm\fdi\abd\usuarios;

use es\ucm\fdi\abd\Aplicacion;
use es\ucm\fdi\abd\usuarios\Usuario;


class FormularioRegistro extends FormularioUsuarioNuevo
{

    public function __construct() {
        parent::__construct();
    }
    
   protected function accionSecundaria($usuario){
        $app = Aplicacion::getInstance();
        $usuario=Usuario::buscaUsuarioPorNombre($usuario->getNombre());

        $app->login($usuario);
    }


}
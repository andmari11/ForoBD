<?php

namespace es\ucm\fdi\abd\usuarios;

use es\ucm\fdi\abd\Aplicacion;
use es\ucm\fdi\abd\Formulario;

class FormularioLogout extends Formulario
{
    public function __construct() {
        parent::__construct('formLogout', [
            'action' =>  Aplicacion::getInstance()->resuelve('/logout.php'),
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $camposFormulario = <<<EOS
            <button class="enlace" type="submit">Cerrar sesión</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        $app->logout();
        $mensajes = ['Hasta pronto !'];
        $app->putAtributoPeticion('mensajes', $mensajes);
        $result = $app->resuelve('/index.php');

        return $result;
    }
}

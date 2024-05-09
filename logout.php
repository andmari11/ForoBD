
<?php
require_once __DIR__.'/includes/config.php';

$app = \es\ucm\fdi\abd\Aplicacion::getInstance();

if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    $app->redirige('/index.php');
}

$formLogout = new \es\ucm\fdi\abd\usuarios\FormularioLogout();
$formLogout->gestiona();

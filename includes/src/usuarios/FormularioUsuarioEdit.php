<?php
namespace es\ucm\fdi\abd\usuarios;

use es\ucm\fdi\abd\Aplicacion;
use es\ucm\fdi\abd\Formulario;

class FormularioUsuarioEdit extends Formulario
{
    public function __construct() {
        $app = Aplicacion::getInstance();
        if ($app->esAdmin())
            parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php'), 'method'=>'POST', 'enctype'=>'multipart/form-data']);
        else
            parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php'), 'method'=>'POST', 'enctype'=>'multipart/form-data']);
    }


    protected function generaCamposFormulario(&$datos) {
        $username = htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));

        $usuario = Usuario::buscaUsuarioPorNombre($username);
        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail(); 
        $rol = $usuario->getRol();
        $app = Aplicacion::getInstance();
        if (!$app->esAdmin() && $app->getUsuarioID()!=$usuario->getId()) {
            return "ACCESO DENEGADO";
        }

        if ($nombre != 'admin') {
            // Generación de mensajes de error si existen
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'rol', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

            $html = <<<EOF
            {$htmlErroresGlobales}
            <h2>Editar usuario</h2>
            <fieldset class="formulario">
                <legend>Editar datos:</legend>
                <div>
                    <label>Nombre:</label><input type="text" name="nombre" value="{$nombre}" required> 
                    {$erroresCampos['nombreUsuario']}
                </div>
                <div>
                    <label>Email:</label><input type="text" name="email" value="{$email}" required> 
                    {$erroresCampos['email']}
                </div>
EOF;
            if (Aplicacion::getInstance()->esAdmin()) {
                $e=($rol === 'e') ? 'selected' : '';
                $m=($rol === 'm') ? 'selected' : '';
                $u=($rol === 'u') ? 'selected' : '';
                $html .= <<<EOF
                <div>
                    <label>Rol:</label> 
                    <select name="rol">
                    <option value="m" $m>Moderador</option>
                    <option value="u" $u>Usuario</option>
                    </select>
                    {$erroresCampos['rol']}
                </div>
EOF;
            } else {
                $html.="<input type='hidden' name='rol' value='{$rol}'>";

                $html .= <<<EOF
                <div>
                    <label>Rol:</label> 
                    <b>{$rol}</b>
                </div>
EOF;
            }
            $html .= <<<EOF
                
                <div>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password">
                    {$erroresCampos['password']}
                </div>
                <div>
                    <label for="password2">Reintroduce el password:</label>
                    <input id="password2" type="password" name="password2">
                    {$erroresCampos['password2']}
                </div>
                <div>
                    <label for="imagen">Imagen:</label><br>
                    <input type="file" id="imagen" name="imagen"><br><br>
                </div>

                <button type="submit">Siguiente</button>
                <input type="hidden" name="nombreAntiguo" value="{$username}">
            </fieldset>
EOF;
        } else {
            $html = "<h2>No es posible editar admin</h2>";
        }
        return $html;
    }

    protected function procesaFormulario(&$datos){

        $nombreAntiguo=htmlspecialchars(trim(strip_tags($_REQUEST["nombreAntiguo"])));
        $usernameNuevo= htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
        $email= htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
        $rol = ($_REQUEST["rol"]);


        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $imagen=null;
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $imagen = $_FILES['imagen'];
            if ($imagen['size'] > 10485760) {
                $this->errores['file'] = 'El tamaño del archivo excede el límite permitido.';
            }
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
            $extensionesPermitidas = array("jpg", "jpeg", "png", "gif");
            if (!in_array($extension, $extensionesPermitidas)) {
                $this->errores['file'] = 'El archivo debe ser una imagen (JPEG, PNG, GIF).';
            } 
        } 

        $contenido="";
        
        if(count($this->errores) === 0 && Usuario::actualizaUsuario($usernameNuevo, $email, $rol, $nombreAntiguo, $password,$imagen)) {
            $contenido = <<<EOS
            <h2>Usuario editado {$usernameNuevo} </h2>
            <p>Vuelta al panel de  <a href='admin.php'>administración</a></p>
            EOS;
            
        
        }else{
            
            $contenido = <<<EOS
                <h2>Error</h2>
                <p>No ha sido posible editar la información del usuario. <a href='admin.php'>Inténtalo de nuevo</a></p>
            EOS;
    
    
        }

        return $contenido;
    }

}
    
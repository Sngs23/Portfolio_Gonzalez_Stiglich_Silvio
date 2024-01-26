<?php
namespace Controllers;
use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if(empty($alertas)){
                //Verifico que el usuario exista
                $usuario = Usuario::where('email',$usuario->email);
                if(!$usuario || !$usuario->confirmado){
                    Usuario::setAlerta('error','El Usuario no existe o no fue confirmado');
                }
                else{
                    //El usuario existe
                    if( password_verify($_POST['password'], $usuario->password) ){
                        //iniciar sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true; 

                        //Redireccionar
                        header('Location: /dashboard');

                    }else{
                        Usuario::setAlerta('error','Password Incorrecto');
                    }
                }
            }
            $alertas = Usuario::getAlertas();
        }
        //Render
        $router->render('auth/login',[
            'titulo' =>'Iniciar Sesion',
            'alertas'=>$alertas
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function crear(Router $router){
        $alertas=[];
        $usuario = new Usuario;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
        
            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);
                
                if($existeUsuario){
                    Usuario::setAlerta('error','El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    //Hashear Password
                    $usuario->hashPassword();
                    //Eliminar Password2 
                    unset($usuario->password2);
                    //Generar el Token
                    $usuario->crearToken();
                    //Crear nuevo usuario
                    $resultado = $usuario->guardar();
                    //Enviar Email
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    
                    $email->enviarConfirmacion();

                    if($resultado){
                        header('Location:/mensaje');
                    }
                }
            }
        }
        //Render a la vista
        $router->render('auth/crear',[
            'titulo' =>'Crear Cuenta en UpTask',
            'usuario'=> $usuario,
            'alertas'=> $alertas 
        ]);

    }
    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                //Buscar el Usuario
                $usuario = Usuario::where('email',$usuario->email); 
            
                if($usuario && $usuario->confirmado){
                    //Generar un nuevo token

                    $usuario->crearToken();
                    unset($usuario->password2);

                    //Actualizar el usuario
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //Imprimir la alerta
                    Usuario::setAlerta('exito','Hemos enviado las Instrucciones a tu email');

                }else{
                    Usuario::setAlerta('error','El Usuario no existe o no esta confirmado');   
                }
            }
        }
        $alertas = Usuario::getAlertas();
        
        //Muestra la vista
        $router->render('auth/olvide',[
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);

    }
    public static function reestablecer(Router $router){
        
        $token = s($_GET['token']);
        $mostrar = true;

        if(!$token) header('Location: /');

        //Identificar Usuario con Token

        $usuario = Usuario::where('token',$token);
        if(empty($usuario)){
            $mostrar=false;
            Usuario::setAlerta('error','Token No Válido');
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //añadir nuevo password

            $usuario->sincronizar($_POST);
            //Validar el password
            $usuario->validarPassword();
            if(empty($alertas)){
                //Hashear Password 
                $usuario->hashPassword();
                //Eliminar Token
                $usuario->token = null;
                //Guardar Usuario
                $resultado = $usuario->guardar();
                //Redireccionar
                if($resultado){
                    header('Location: /');
                }

            }
        }
        $alertas = Usuario::getAlertas();
        // Muestra la vista
        $router->render('auth/reestablecer',[
            'titulo'=>'Reestablecer Password',
            'alertas'=>$alertas,
            'mostrar'=>$mostrar
        ]);
    }
    public static function mensaje(Router $router){
        
        $router->render('auth/mensaje', [
            'titulo'=>'Cuenta Creada Exitosamente'
            ]);
    }
    public static function confirmar(Router $router){
        
        $token = s($_GET['token']);
        if(!$token) header('Location: /');

        //Encontrar al Usuario con el token
        $usuario = Usuario::where('token',$token);
        if(empty($usuario)){
            //No se encontro usuario con ese token
            Usuario::setAlerta('error','Token no Válido');
        }else{
            //Confirmar la cuenta
            $usuario->confirmado=1;
            $usuario->token = null;
            unset($usuario->password2);
            
            //Guardar en la Base de Datos
            $usuario->guardar();

            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');

        }
        $alertas = Usuario::getAlertas();


        $router->render('auth/confirmar',[
            'titulo' => 'Confirma Tu cuenta',
            'alertas' => $alertas
        ]);
    }
}
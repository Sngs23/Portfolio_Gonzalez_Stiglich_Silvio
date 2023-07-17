<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;
class LoginController{
    public static function login(Router $router){
        $errores = [];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Admin($_POST);
            $errores = $auth->validar();

            if(empty($errores)){
                //verificar si existe el usuario
                $resultado = $auth->existeUsuario();
                if(!$resultado){
                    // email incorrecto mensaje error
                    $errores = Admin::getErrores();
                }
                else{
                    //verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);
                    if($autenticado){
                        //autenticar usuario
                        $auth->autenticar();
                    }
                    else{
                        // Password incorrecto mensaje error
                        $errores = Admin::getErrores();
                    }
                }
              
            }
        }
        $router->render('auth/login',[
            "errores" => $errores
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

}
<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{
    public static function index(Router $router){

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        $resultado = $_GET['resultado'] ?? null;
        $router->render('propiedades/admin',[
            'propiedades' => $propiedades,
            'resultado'=> $resultado,
            'vendedores'=> $vendedores
    ]);
    }
    public static function crear(Router $router){
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        //ARREGLO CON MENSAJES DE ERRORES
        $errores = Propiedad::getErrores();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Crea una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);

            //generar nombre unico
            $nombreImagen = md5( uniqid(rand(),true)) . ".jpg" ;
            
            //Setear imagen 
            //REALIZA RESIZE IMAGEN CON INTERVENTION 
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);  
            }
            //Validamos 
            $errores = $propiedad->validar();
            
            //Revisar array de errores 
            if (empty($errores)){

                //Crear la carpeta para subir Imagenes
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }

                //Guarda la imagen en servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                //Guardar Base de Datos
                $propiedad -> guardar();
            }
        }        
        
        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        
        $errores = Propiedad::getErrores();

        // Ejecutar el código después de que el usuario envia el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** Crea una nueva instancia */
            $propiedad = new Propiedad($_POST['propiedad']);

            // Generar un nombre único
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";


            // Setear la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

            // Validar
            $errores = $propiedad->validar();
            if(empty($errores)) {

                // Crear la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guarda en la base de datos
                $resultado = $propiedad->guardar();

                if($resultado) {
                    header('location: /propiedades');
                }
            }
        }




        $router->render('/propiedades/actualizar',[
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores'=>$vendedores
        ]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id=$_POST['id'];
            $id=filter_var($id,FILTER_VALIDATE_INT);
            if($id){
                $tipo = $_POST['tipo']; 
                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();  
                }
            }
        }
    }
}
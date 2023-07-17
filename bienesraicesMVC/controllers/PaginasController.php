<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use mail\mail\mail;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::get(3);

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => true
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros', []);
    }
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad

        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $respuestas = $_POST['contacto'];
            //crear una instancia php mailer
            $mail = new PHPMailer();
            //configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '97fa3cd00b6a9b';
            $mail->Password = 'c71f2611b121e0';
            $mail->SMTPSecure = 'tls';
            //Configurar contenido del Email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes Un Nuevo Mensaje';

            //Habilitar HTML

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .='<p>Tienes un nuevo Mensaje</p>';
            $contenido .='<p>Nombre: '. $respuestas['nombre'] .'</p>';
            
            //Enviar de forma Condicional algunos campos de email o telefono

            if($respuestas['contacto'] === 'telefono'){
                $contenido.= '<p>Eligio ser Contactado por Telefono.</p>';
                $contenido .='<p>Telefono: '. $respuestas['telefono'] .'</p>';
                $contenido .='<p>Fecha: '. $respuestas['fecha'] .'</p>';
                $contenido .='<p>Hora: '. $respuestas['hora'] .'</p>';
            }else{
                $contenido.= '<p>Eligio ser Contactado por Email.</p>';
                $contenido .='<p>Email: '. $respuestas['email'] .'</p>';
            }

            
            $contenido .='<p>Vende o Compra: '. $respuestas['tipo'] .'</p>';
            $contenido .='<p>Prefiere ser Contactado por: '. $respuestas['contacto'] .'</p>';
            $contenido .='<p>Precio: $ '. $respuestas['precio'] .'</p>';

            $contenido .='<p>Mensaje: '. $respuestas['mensaje'] .'</p>';
            $contenido .='</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'texto alternativo sin html';

            //Enviar Email
            if ($mail->send()) {
                $mensaje = 'Mensaje Enviado Correctamente';
            } else {
                $mensaje = 'Error, no se pudo enviar el Mensaje';
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}

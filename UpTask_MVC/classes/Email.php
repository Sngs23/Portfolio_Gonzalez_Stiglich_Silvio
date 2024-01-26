<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '97fa3cd00b6a9b';
        $mail->Password = 'c71f2611b121e0';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com','uptask.com');
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong> Hola" . $this->nombre . "</strong> Has Creado tu cuenta en Uptask, solo debes Confirmarla en el siguiente enlace </p>";
        $contenido .="<p>Presiona Aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido .=" <p>Si tu no creaste una cuenta, puedes ignorar el mensaje.</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        //Enviar Email
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '97fa3cd00b6a9b';
        $mail->Password = 'c71f2611b121e0';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com','uptask.com');
        $mail->Subject = 'Reestablece tu Password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong> Hola" . $this->nombre . "</strong> Parece que has olvidado tu contraseña, abre el siguiente enlace para recuperarlo  </p>";
        $contenido .="<p>Presiona Aquí: <a href='http://localhost:3000/reestablecer?token=" . $this->token ."'>Reestablecer Contraseña</a></p>";
        $contenido .=" <p>Si tu no creaste una cuenta, puedes ignorar el mensaje.</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
        //Enviar Email
        $mail->send();
    }

}
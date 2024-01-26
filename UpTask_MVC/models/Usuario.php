<?php 

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';

        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // Validar el Login de Usuario
    public function validarLogin(){
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El Email no es válido';    
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        return self::$alertas; 
    }

    //validacion cuentas nuevas
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del cliente es Obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password)< 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][] = 'Los Password no Coinciden';
        }
        
        return self::$alertas;
    }
    //Valida un Email
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El Email no es válido';    
        }

        return self::$alertas;
    }
    //Valida el password
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password)< 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas; 
    }

    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        return self::$alertas;
    }

    public function nuevo_password(): array{
        if(!$this->password_actual){
            self::$alertas['error'][] = 'El password actual no puede ir vacio';
        }
        if(!$this->password_nuevo){
            self::$alertas['error'][] = 'El password nuevo no puede ir vacio';
        }

        if(strlen($this->password_nuevo) < 6){
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }
    //Comprobar Password
    public function comprobar_password(): bool{
        return password_verify($this->password_actual, $this->password);
    }
    //Hashear Password
    public function hashPassword(): void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    //Generar un Token
    public function crearToken(): void{
        $this->token = uniqid();
    }
}
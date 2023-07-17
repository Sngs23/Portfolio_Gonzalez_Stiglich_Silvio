<?php

namespace  Model;

class ActiveRecord{
    protected static $db; 
    protected static $columnasDB = [];
    protected static $tabla = '';

    //ERRORES  
    protected static $errores = [];

 
    //Definir conexion base de datos
    public static function setDB($database){
        self::$db = $database; 
    }

    public function guardar(){
        if(!is_null($this->id)){
            //actualizar
            $this->actualizar();
        }else{
            $this->crear();
        }
    } 

        //BUsca un registro por su id
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id= {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public function crear(){
        
        // SANITIZAR DATOS  
        $atributos = $this->sanitizarDatos();
        //INSERTAR EN BD
        $query = " INSERT INTO ". static::$tabla . " ( ";
        $query.= join(', ',array_keys($atributos));
        $query.= ") VALUES (' ";
        $query.=join("', '", array_values($atributos));
        $query.= " ') ";
        
        $resultado = self::$db->query($query);

        if ($resultado) {
            echo "Insertado Correctamente";
            //Redireccionar usuario
            header ('location: ../admin?resultado=1');
        }
    }
    public function actualizar(){
        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE ". static::$tabla." SET ";
        $query .= join(', ',$valores);
        $query .= "WHERE id = '" . self::$db->escape_string($this->id) ."' ";
        $query .=" LIMIT 1 ";
        $resultado = self::$db->query($query); 

        if ($resultado) {
            echo "Insertado Correctamente";
            //Redireccionar 
            header ('location: /admin?resultado=2');
        }
    }
    //Eliminar un registro
    public function eliminar(){
        $query = " DELETE FROM ". static::$tabla . " WHERE id = ". self::$db->escape_string($this->id). " LIMIT 1";
        $resultado = self::$db->query($query);
        
        if($resultado){
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }


    //IDENTIFICAR Y UNIR ATRIBUTOS DE LA BD
    public function atributos(){
        $atributos =[];
        foreach(static::$columnasDB as $columna){
            if($columna === 'id'){
                continue;
            }
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key =>$value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
    //Subida de archivos
    public function setImagen($imagen){
        //Eliminar Imagen Previa
        if(!is_null($this->id)){
            $this->borrarImagen();
        }
        if($imagen){
            //asigna al atributo de imagen el nombre de la imagen 
            $this->imagen = $imagen;
        }
    }

    //Eliminar 
    public function borrarImagen(){
        //compruebo que existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen); 
        }
    }



    //VALIDACION 
    public static function getErrores(){
        return static::$errores;
    }
    public function validar(){
        static::$errores=[];
        return static::$errores;
    }

    //Lista todos los Registros
    public static function all(){
        $query = "SELECT * FROM ". static::$tabla;
        $resultado = self::consultarSQL($query);
     
        return $resultado;
    }
    //Obtiene determinado nmero de registro
    public static function get($cantidad){
        $query = "SELECT * FROM ". static::$tabla . ' LIMIT '.$cantidad;
        $resultado = self::consultarSQL($query);
     
        return $resultado;
    }

    public static function consultarSQL($query){
        //Consultar BD
        $resultado = self::$db->query($query);
        //Iterar Resultados
        $array =[];
        while($registro = $resultado->fetch_assoc()){
            $array[]=static::crearObjeto($registro);
        }

        //Liberar memoria
        $resultado->free();
        //Retornar
        return $array;
    }
    protected static function crearObjeto($registro){
        $objeto = new static;
        foreach($registro as $key => $value){
            if(property_exists($objeto,$key)){
                $objeto->$key = $value; 
            }
        }
        return $objeto; 
    }

    //Sincronizar Objeto en memoria con cambios realizados por el usuario
    public function sincronizar( $args=[] ){
        foreach($args as $key => $value){
            if(property_exists($this,$key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    } 

}
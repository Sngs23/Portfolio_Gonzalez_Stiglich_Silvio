<?php

namespace Model;

//Base de Datos


class Propiedad extends ActiveRecord{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion','habitaciones','wc','estacionamiento','creado','vendedorId'];
    
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar(){
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if (!$this->precio) {
            self::$errores[] = "Debes añadir el precio";
        }
        if (strlen($this->descripcion) < 20) {
            self::$errores[] = "Debes añadir una descripcion al menos 20 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "Debes añadir cantidad habitaciones ";
        }
        if (!$this->wc) {
            self::$errores[] = "Debes añadir cantidad baños ";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "Debes añadir estacionamientos ";
        }
        if (!$this->vendedorId) {
            self::$errores[] = "Debes añadir vendedor ";
        }
       if(!$this->imagen){
            self::$errores[] = "La imagen de la propiedad es obligatoria"; 
        }

        return self::$errores;
    }

}
<?php

namespace Controllers;

use Model\EventoHorario;

class APIPonentes {
    public function index(){
        $ponentes = POnente::all();
        echo json_encode($ponentes);
    }

    public static function ponente(){
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);

        if(!$id || $id < 1){
            echo json_encode([]);
        }
        $ponente = Ponente::find($id);
        echo json_encode($ponente, JSON_UNESCAPED_SLASHES);
    }
}
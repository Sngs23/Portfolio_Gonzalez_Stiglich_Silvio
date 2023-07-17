<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__.'/../vendor/autoload.php';

use Model\ActiveRecord;

$db = conectarBD();
ActiveRecord::setDB($db);
?>
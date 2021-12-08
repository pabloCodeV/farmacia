<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//ARCHIVOS REQUERIDOS PARA EL CORRECTO FUNCIONAMIENTO
require '../vendor/autoload.php';
require 'routes/config/db.php';

$app = new \Slim\App;

//RUTAS DE LAS APIS A UTILIZAR
require 'routes/farmacias.php';
require 'routes/usuarios.php';

$app->run();
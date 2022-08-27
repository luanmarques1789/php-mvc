<?php

include_once 'bootstrap.php';

use \App\Http\Router;
use App\Utils\View;

// Definindo o valor padrão das variáveis
View::init(['URL' => URL]);

$router = new Router(URL);

// Inclui as rotas de páginas
include_once __DIR__ . '/app/routes/pages.php';

$router->runRoute()->sendResponse();

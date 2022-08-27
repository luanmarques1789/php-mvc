<?php

include_once __DIR__ . '/includes/app.php';

use \App\Http\Router;

$router = new Router(URL);

// Inclui as rotas de páginas
include_once __DIR__ . '/app/routes/pages.php';

$router->runRoute()->sendResponse();

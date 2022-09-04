<?php

include_once __DIR__ . '/includes/app.php';

use \App\Http\Router;

$router = new Router(URL);

// Inclui as rotas da aplicação
include_once __DIR__ . '/app/routes/index.php';
include_once __DIR__ . '/app/routes/admin.php';

$router->runRoute()->sendResponse();

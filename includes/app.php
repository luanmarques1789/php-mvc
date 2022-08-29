<?php

include_once __DIR__ . '/../bootstrap.php';

use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

// Definindo configurações de banco de dados
Database::config(
  DB_HOST,
  DB_NAME,
  DB_USER,
  DB_PASSWORD
);

// Definindo o valor padrão das variáveis
View::init(['URL' => URL]);


// Definindo o mapeamento de middlewares
MiddlewareQueue::setMap([
  'maintenance' => \App\Http\Middleware\Maintenance::class
]);

// Configura os middlewares padrões
MiddlewareQueue::setDefaultMiddlewares([
  'maintenance'
]);

<?php

include_once __DIR__ . '/../bootstrap.php';

use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Database;

// Middlewares
use \App\Http\Middleware\Queue as MiddlewareQueue;
use \App\Http\Middleware\Maintenance;
use \App\Http\Middleware\RequireAdminLogin;
use \App\Http\Middleware\RequireAdminLogout;

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
  'maintenance' => Maintenance::class,
  'required-admin-logout' => RequireAdminLogout::class,
  'required-admin-login' => RequireAdminLogin::class
]);

// Configura os middlewares padrões
MiddlewareQueue::setDefaultMiddlewares([
  'maintenance'
]);

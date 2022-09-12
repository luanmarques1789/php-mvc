<?php

use \App\Http\Response;
use \App\Controller;

// Rota login
$router->get('/login', [
  'middlewares' => ['required-admin-logout'],
  function ($request) {
    return  new Response(200, Controller\Login::getLogin($request));
  }
]);

$router->post('/login', [
  'middlewares' => ['required-admin-logout'],
  function ($request) {
    return  new Response(200, Controller\Login::setLogin($request));
  }
]);

// Rota logout
$router->get('/logout', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Controller\Login::setLogout($request));
  }
]);

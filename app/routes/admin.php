<?php

use \App\Http\Response;
use \App\Controller\Admin;

// Rota admin
$router->get('/admin', [
  'middlewares' => [
    'required-admin-login'
  ],
  function () {
    return  new Response(200, 'Página de administração');
  }
]);

// Rota login
$router->get('/admin/login', [
  'middlewares' => ['required-admin-logout'],
  function ($request) {
    return  new Response(200, Admin\Login::getLogin($request));
  }
]);

$router->post('/admin/login', [
  'middlewares' => ['required-admin-logout'],
  function ($request) {
    return  new Response(200, Admin\Login::setLogin($request));
  }
]);

// Rota logout
$router->get('/admin/logout', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Login::setLogout($request));
  }
]);

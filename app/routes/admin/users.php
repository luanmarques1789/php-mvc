<?php

use \App\Http\Response;
use \App\Controller\Admin\User;

// Rota de listagem de usuários
$router->get('/admin/users', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, User::getUsers($request));
  }
]);

$router->get('/admin/users/new', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, User::getUserForm($request));
  }
]);

// Inserção de um novo usuário
$router->post('/admin/users/new', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, User::createNewUser($request));
  }
]);

// Edição de um usuário
$router->get('/admin/users/{id}/edit', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, User::getUserEditionForm($request, $id));
  }
]);

$router->post('/admin/users/{id}/edit', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, User::editUser($request, $id));
  }
]);

// Rota de exclusão de um usuário
$router->get('/admin/users/{id}/delete', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, User::getUserExclusionForm($request, $id));
  }
]);

$router->post('/admin/users/{id}/delete', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, User::deleteUser($request, $id));
  }
]);

<?php

use \App\Http\Response;
use \App\Controller\Admin;

// Rota de listagem de depoimentos
$router->get('/admin/testimonies', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Testimony::getTestimonies($request));
  }
]);

$router->get('/admin/testimonies/new', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Testimony::getTestimonyForm($request));
  }
]);

// Inserção de um novo depoimento
$router->post('/admin/testimonies/new', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Testimony::createNewTestimony($request));
  }
]);

// Edição de um depoimento
$router->get('/admin/testimonies/{id}/edit', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, Admin\Testimony::getTestimonyEditionForm($request, $id));
  }
]);

$router->post('/admin/testimonies/{id}/edit', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, Admin\Testimony::editTestimony($request, $id));
  }
]);

// Rota de exclusão de um depoimento
$router->get('/admin/testimonies/{id}/delete', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, Admin\Testimony::getTestimonyExclusionForm($request, $id));
  }
]);

$router->post('/admin/testimonies/{id}/delete', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, Admin\Testimony::deleteTestimony($request, $id));
  }
]);

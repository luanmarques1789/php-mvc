<?php

use \App\Http\Response;
use \App\Controller;

// Inclui as rotas de login e logout
include_once __DIR__ . '/login.php';

// Rota home
$router->get('/', [
  function () {
    return  new Response(200, Controller\Home::getHome());
  }
]);

// Rota sobre 
$router->get('/sobre', [
  function () {
    return  new Response(200, Controller\About::getAbout());
  }
]);

$router->get('/depoimentos', [
  function ($request) {
    return  new Response(200, Controller\Testimony::getTestimonies($request));
  }
]);

$router->post('/depoimentos', [
  function ($request) {
    return  new Response(200, Controller\Testimony::insertTestimony($request));
  }
]);

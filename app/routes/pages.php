<?php

use \App\Http\Response;
use \App\Controller\Pages;

// Rota home
$router->get('/', [
  function () {
    return  new Response(200, Pages\Home::getHome());
  }
]);

// Rota sobre 
$router->get('/sobre', [
  function () {
    return  new Response(200, Pages\About::getAbout());
  }
]);

// Rota dinâmica
$router->get('/pagina/{pageID}/{acao}', [
  function ($pageID, $acao) {
    return new Response(200, 'Página ' . $pageID . ' - ' . $acao);
  }
]);

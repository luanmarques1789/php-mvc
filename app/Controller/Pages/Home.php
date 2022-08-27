<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home extends Page
{
  /**
   * Método responsável por retornar a `view` da página home.
   */
  public static function getHome()
  {
    // View da home
    $content = View::render('home', [
      'title' => 'Título da HOME'
    ]);

    // Retorna a view da página
    return parent::getPage('LUAN DEV', $content);
  }
}

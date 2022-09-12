<?php

namespace App\Controller;

use \App\Utils\View;

class About extends Page
{
  /**
   * Método responsável por retornar a `view` da página sobre.
   */
  public static function getAbout()
  {
    $content = View::render('Pages/about', []);

    // Retorna a view da página
    return parent::getPage('About', $content);
  }
}

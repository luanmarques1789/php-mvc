<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Page
{
  /**
   * Retorna a view da estrutura genética do painel de administrador
   *
   * @param  mixed $title
   * @param  mixed $content
   * @return string
   */
  public static function getPage($title, $content)
  {
    return View::render('admin/page', [
      'title' => $title,
      'content' => $content
    ]);
  }
}

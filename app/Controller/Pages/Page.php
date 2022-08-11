<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{
  /**
   * Método responsável por retornar a `view` da página genérica.
   * @param string $title Título da página.
   * @param string $content Conteúdo da página.
   */
  public static function getPage($title, $content)
  {
    return View::render('page', [
      'title' => $title,
      'content' => $content,
      'header' => self::getHeader(),
      'footer' => self::getFooter(),
    ]);
  }


  /**
   * Renderiza o cabeçalho da página
   *
   * @return string Cabeçalho da página
   */
  private static function getHeader()
  {
    return View::render('header');
  }
  /**
   * Renderiza o rodapé da página
   *
   * @return string Rodapé da página
   */
  private static function getFooter()
  {
    return View::render('footer');
  }
}

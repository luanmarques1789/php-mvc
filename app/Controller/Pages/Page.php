<?php

namespace App\Controller\Pages;

use App\Http\Request;
use \App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Page
{
  /**
   * Renderizar o layout de paginação 
   *
   * @param  Request $request Objeto de Request
   * @param  Pagination $pagination Objeto de Pagination
   * @return string Retorna o box de paginação
   */
  public static function getPagination($request, $pagination)
  {
    $pages = $pagination->getPages();

    // Verificando a quantidade de páginas
    if (count($pages) <= 1) return '';

    $links = '';

    // URL atual (sem parâmetros GET)
    $cleanUrl = $request->getRouter()->getCurrentUrl();

    // Parâmetros GET
    $queryParams = $request->getQueryParams();

    // Renderiza os links
    foreach ($pages as $page) {
      // Altera a página
      $queryParams['page'] = $page['page'];

      // Link
      $link = $cleanUrl . '?' . http_build_query($queryParams);

      // View
      $links .= View::render('Pagination/link', [
        'pageNumber' => $page['page'],
        'link' => $link,
        'active' => $page['current'] ? 'active' : ''
      ]);
    }

    return View::render('Pagination/box', [
      'links' => $links
    ]);
  }

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

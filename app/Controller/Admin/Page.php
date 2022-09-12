<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

class Page
{
  /**
   * Módulos disponíveis no painel
   */
  private static $modules = [
    'home' => [
      'label' => 'Home',
      'href' => URL . '/admin'
    ],
    'testimonies' => [
      'label' => 'Depoimentos',
      'href' => URL . '/admin/testimonies'
    ],
    'users' => [
      'label' => 'Usuários',
      'href' => URL . '/admin/users'
    ],
  ];

  /**
   * Retorna a view da estrutura genética do painel de administrador
   *
   * @param  mixed $title
   * @param  mixed $content
   * @return string
   */
  public static function getPage($title, $content)
  {
    return View::render('Admin/page', [
      'title' => $title,
      'content' => $content
    ]);
  }

  /**
   * Renderizar a view do painel com conteúdos dinâmicos
   *
   * @param  string $title
   * @param  string $content
   * @param  string $currentModule
   * @return string
   */
  public static function getPanel($title, $content, $currentModule)
  {
    $contentPanel = View::render('Admin/panel', [
      'menu' => self::getMenu($currentModule),
      'content' => $content
    ]);
    return self::getPage($title, $contentPanel);
  }


  /**
   * Renderiza a view do menu
   *
   * @param  string $currentModule
   * @return string
   */
  private static function getMenu($currentModule)
  {
    $links = '';

    foreach (self::$modules as $hash => $module) {
      $links .= View::render('Admin/Menu/link', [
        'href' => $module['href'],
        'label' => $module['label'],
        'currentModule' => $hash == $currentModule ? 'text-primary' : ''
      ]);
    }

    return View::render('Admin/Menu/box', [
      'brand' => 'MVC',
      'links' => $links
    ]);
  }

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
      $links .= View::render('Admin/Pagination/link', [
        'pageNumber' => $page['page'],
        'link' => $link,
        'active' => $page['current'] ? 'active' : ''
      ]);
    }

    return View::render('Pages/Pagination/box', [
      'links' => $links
    ]);
  }
}

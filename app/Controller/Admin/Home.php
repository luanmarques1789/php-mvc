<?php

namespace App\Controller\Admin;


use App\Http\Request;
use App\Utils\View;

class Home extends Page
{

  /**
   * Renderiza a view home de admin
   *
   * @param  Request $request
   * @return string
   */
  public static function getHome($request)
  {
    $content = View::render('Admin/Modules/Home/index', []);

    return parent::getPanel('Depoimentos', $content, 'home');
  }
}

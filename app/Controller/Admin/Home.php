<?php

namespace App\Controller\Admin;


use App\Utils\View;
use App\Http\Request;

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
    $content = View::render('Admin/Modules/Home/index', [
      'name' => $_SESSION['user']['name']
    ]);

    return parent::getPanel('Home - Admin', $content, 'home');
  }
}

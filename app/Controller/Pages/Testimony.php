<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Http\Request;
use \App\Models\Entities\Testimony as EntityTestimony;

class Testimony extends Page
{
  /**
   * Método responsável por retornar a `view` de depoimentos.
   */
  public static function getTestimonies()
  {
    $content = View::render('Testimony/testimonies', [
      'title' => 'Depoimentos',
      'testimonies' => self::getTestimoniesItems(),
    ]);

    // Retorna a view da página
    return parent::getPage('LUAN DEV', $content);
  }

  /**
   * Obter renderização dos itens de depoimentos para a página
   *
   * @return string
   */
  private static function getTestimoniesItems()
  {
    // Depoimentos
    $items = '';

    // Resultado da consuta da tabela de depoimentos
    $tableRows = EntityTestimony::getTestimonies(order: 'id DESC');

    // Concatenando depoimentos
    while ($testimony = $tableRows->fetchObject(EntityTestimony::class)) {
      $items .= View::render('Testimony/item', [
        'name' => $testimony->nome,
        'date' => date('d/m/Y H:i:s', strtotime($testimony->data)),
        'message' => $testimony->mensagem,
      ]);
    }

    return $items;
  }

  /**
   * Inserir um depoimento
   *
   * @param Request $request
   * @return string 
   */
  public static function insertTestimony($request)
  {
    // Dados do método POST
    $postVars = $request->getPostVars();

    // Nava instância de depoimento
    $testimony = new EntityTestimony();
    $testimony->name = $postVars['name'];
    $testimony->message = $postVars['message'];
    $testimony->register();

    return self::getTestimonies();
  }
}

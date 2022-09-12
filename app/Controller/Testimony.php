<?php

namespace App\Controller;

use \App\Utils\View;
use \App\Http\Request;
use \App\Models\Entities\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
  /**
   * Método responsável por retornar a `view` de depoimentos.
   * @param Request $request Instância de requisição
   */
  public static function getTestimonies($request)
  {
    $content = View::render('Pages/Testimony/testimonies', [
      'title' => 'Depoimentos',
      'testimonies' => self::getTestimoniesItems($request, $pagination),
      'pagination' => parent::getPagination($request, $pagination),
    ]);

    // Retorna a view da página
    return parent::getPage('LUAN DEV', $content);
  }

  /**
   * Obter renderização dos itens de depoimentos para a página
   * @param Request $request Instância de requisição
   * @param Pagination $pagination Instância de Pagination
   * @return string
   */
  private static function getTestimoniesItems($request, &$pagination)
  {
    // Depoimentos
    $items = '';

    // Quantidade total de registros
    $totalRows = EntityTestimony::getTestimonies(fields: 'COUNT(*) as total')->fetchObject()->total;

    // Obtendo a página atual
    $queryParams = $request->getQueryParams();
    $currentPage = $queryParams['page'] ?? 1;

    // Instância de paginação
    $pagination = new Pagination($totalRows, $currentPage, 2);


    // Resultado da consulta da tabela de depoimentos
    $tableRows = EntityTestimony::getTestimonies(order: 'id DESC', limit: $pagination->getLimit());

    // Concatenando depoimentos
    while ($anTestimonyRow = $tableRows->fetchObject(EntityTestimony::class)) {
      $items .= View::render('Pages/Testimony/item', [
        'name' => $anTestimonyRow->nome,
        'date' => date('d/m/Y H:i:s', strtotime($anTestimonyRow->data)),
        'message' => $anTestimonyRow->mensagem,
      ]);
    }


    return $items;
  }

  /**
   * Inserir um depoimento
   *
   * @param Request $request
   * @return string Retorna a página de listagem de depoimentos após inserção de depoimento
   */
  public static function insertTestimony($request)
  {
    // Dados do método POST
    $postVars = $request->getPostVars();

    // Nova instância de depoimento
    $testimony = new EntityTestimony();

    $testimony->nome = $postVars['name'];
    $testimony->mensagem = $postVars['message'];
    $testimony->register();

    // Retorna a página de listagem de depoimentos
    return self::getTestimonies($request);
  }
}

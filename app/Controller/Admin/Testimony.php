<?php

namespace App\Controller\Admin;


use App\Http\Request;
use App\Models\Entities\Testimony as EntityTestimony;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{

  /**
   * Renderiza a view de listagem de 
   *
   * @param  Request $request
   * @return string
   */
  public static function getTestimonies($request)
  {
    $content = View::render('Admin/Modules/Testimonies/index', [
      'items' => self::getTestimoniesItems($request, $pagination),
      'buttonText' => 'Cadastrar depoimento',
      'pagination' => parent::getPagination($request, $pagination),
      'status' => self::getStatus($request)

    ]);

    return parent::getPanel('Depoimentos - Admin', $content, 'testimonies');
  }

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
    while ($aTestimonyRow = $tableRows->fetchObject(EntityTestimony::class)) {
      $items .= View::render('Admin/Modules/Testimonies/item', [
        'id' => $aTestimonyRow->id,
        'name' => $aTestimonyRow->nome,
        'message' => $aTestimonyRow->mensagem,
        'date' => date('d/m/Y H:i:s', strtotime($aTestimonyRow->data)),
      ]);
    }

    return $items;
  }

  /**
   * Retorna o formulário de cadastro de um novo depoimento
   *
   * @param  Request $request
   * @return string
   */
  public static function getTestimonyForm($request)
  {
    // Conteúdo formulário
    $content = View::render('Admin/Modules/Testimonies/form', [
      'title' => 'Cadastrar depoimento',
      'name' => '',
      'message' => '',
      'status' => ''
    ]);

    return parent::getPanel('Cadastrar depoimento', $content, 'testimonies');
  }

  /**
   * Cadastra um novo depoimento no banco de dados
   *
   * @param  Request $request
   * @return void
   */
  public static function createNewTestimony($request)
  {
    $postVars = $request->getPostVars();

    $testimony = new EntityTestimony();

    $testimony->nome = $postVars['name'] ?? '';
    $testimony->mensagem = $postVars['message'] ?? '';
    $testimony->register();

    $request->getRouter()->redirect("/admin/testimonies/{$testimony->id}/edit?status=created");
  }

  /**
   * Retorna o formulário de edição de um depoimento
   *
   * @param  Request $request
   * @param int $id
   * @return string
   */
  public static function getTestimonyEditionForm($request, $id)
  {
    $testimony = EntityTestimony::getTestimonyById($id);

    // Valida instância
    if (!$testimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    // Conteúdo formulário
    $content = View::render('Admin/Modules/Testimonies/form', [
      'title' => 'Editar depoimento',
      'id' => $testimony->id,
      'name' => $testimony->nome,
      'message' => $testimony->mensagem,
      'status' => self::getStatus($request)

    ]);

    return parent::getPanel('Cadastrar Depoimento', $content, 'testimonies');
  }

  /**
   * Salva as edições de um depoimento 
   *
   * @param  Request $request
   * @param  int $id
   * @return void
   */
  public static function editTestimony($request, $id)
  {
    $testimony = EntityTestimony::getTestimonyById($id);

    // Valida instância
    if (!$testimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    $postVars = $request->getPostVars();

    $testimony->nome = $postVars['name'] ?? $testimony->nome;
    $testimony->mensagem = $postVars['message'] ?? $testimony->mensagem;
    $testimony->updateTestimony();

    $request->getRouter()->redirect("/admin/testimonies/{$testimony->id}/edit?status=updated");
  }

  /**
   * Retorna mensagem de status
   *
   * @param  Request $request
   * @return string
   */
  public static function getStatus($request)
  {
    $queryParams = $request->getQueryParams();

    if (!isset($queryParams['status'])) return '';

    switch ($queryParams['status']) {
      case 'created':
        return Alert::getSuccess('Depoimento <b>criado</b> com sucesso!');
      case 'updated':
        return Alert::getSuccess('Depoimento <b>atualizado</b> com sucesso!');
      case 'deleted':
        return Alert::getSuccess('Depoimento <b>excluído</b> com sucesso!');
      default:
        return '';
    }
  }

  /**
   * Retorna o formulário de exclusão de um depoimento
   *
   * @param  Request $request
   * @param int $id
   * @return string
   */
  public static function getTestimonyExclusionForm($request, $id)
  {
    $testimony = EntityTestimony::getTestimonyById($id);

    // Valida se existe uma instância de depoimento
    if (!$testimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    // Conteúdo formulário
    $content = View::render('Admin/Modules/Testimonies/exclusion', [
      'title' => 'Excluir depoimento',
      'name' => $testimony->nome,
      'message' => $testimony->mensagem,

    ]);

    return parent::getPanel('Excluir depoimento', $content, 'testimonies');
  }

  /**
   * Excluir um depoimento
   *
   * @param  Request $request
   * @param  int $id
   * @return void
   */
  public static function deleteTestimony($request, $id)
  {
    $testimony = EntityTestimony::getTestimonyById($id);

    // Valida se existe uma instância de depoimento
    if (!$testimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    // Exclui o depoimento
    $testimony->deleteTestimony();

    $request->getRouter()->redirect("/admin/testimonies?status=deleted");
  }
}

<?php

namespace App\Controller\Admin;


use App\Utils\View;
use App\Http\Request;
use App\Models\Entities\User as EntityUser;
use WilliamCosta\DatabaseManager\Pagination;
use App\Controller\Alert;

class User extends Page
{

  /**
   * Renderiza a view de listagem de 
   *
   * @param  Request $request
   * @return string
   */
  public static function getUsers($request)
  {
    $content = View::render('Admin/Modules/Users/index', [
      'title' => 'Painel de Usuários',
      'items' => self::getUsersItems($request, $pagination),
      'buttonText' => 'Cadastrar usuário',
      'pagination' => parent::getPagination($request, $pagination),
      'status' => self::getStatus($request)

    ]);

    return parent::getPanel('Usuários - Admin', $content, 'users');
  }

  private static function getUsersItems($request, &$pagination)
  {
    // Usuários
    $usersItems = '';

    // Quantidade total de registros
    $totalRows = EntityUser::getUsers(fields: 'COUNT(*) as total')->fetchObject()->total;

    // Obtendo a página atual
    $queryParams = $request->getQueryParams();
    $currentPage = $queryParams['page'] ?? 1;

    // Instância de paginação
    $pagination = new Pagination($totalRows, $currentPage, 5);


    // Resultado da consulta da tabela de usuários
    $tableRows = EntityUser::getUsers(order: 'id DESC', limit: $pagination->getLimit());

    // Concatenando usuários
    while ($anUserRow = $tableRows->fetchObject(EntityUser::class)) {
      $usersItems .= View::render('Admin/Modules/Users/item', [
        'id' => $anUserRow->id,
        'name' => $anUserRow->nome,
        'email' => $anUserRow->email,
      ]);
    }

    return $usersItems;
  }

  /**
   * Retorna o formulário de cadastro de um novo usuário
   *
   * @param  Request $request
   * @return string
   */
  public static function getUserForm($request)
  {
    // Conteúdo formulário
    $content = View::render('Admin/Modules/Users/form', [
      'title' => 'Cadastrar usuário',
      'name' => '',
      'email' => '',
      'status' => self::getStatus($request)
    ]);

    return parent::getPanel('Cadastrar usuário', $content, 'users');
  }

  /**
   * Cadastra um novo usuário no banco de dados
   *
   * @param  Request $request
   * @return void
   */
  public static function createNewUser($request)
  {
    $postVars = $request->getPostVars();
    $name = $postVars['name'] ?? '';
    $email = trim($postVars['email'] ?? '');
    $password = $postVars['password'] ?? '';

    $userEmail = EntityUser::getUserByEmail($email);
    // Valida se o email já existe
    if ($userEmail instanceof EntityUser) {
      $request->getRouter()->redirect('/admin/users/new?status=duplicated');
    }

    $user = new EntityUser();
    $user->nome = trim($name);
    $user->email = $email;
    $user->senha = EntityUser::generatePassword($password);
    $user->register();

    $request->getRouter()->redirect("/admin/users/{$user->id}/edit?status=created");
  }

  /**
   * Retorna o formulário de edição de um usuário
   *
   * @param  Request $request
   * @param int $id
   * @return string
   */
  public static function getUserEditionForm($request, $id)
  {
    $user = EntityUser::getUserById($id);

    // Valida instância
    if (!$user instanceof EntityUser) {
      $request->getRouter()->redirect('/admin/users');
    }

    // Conteúdo formulário
    $content = View::render('Admin/Modules/Users/form', [
      'title' => 'Editar usuário',
      'id' => $user->id,
      'name' => $user->nome,
      'email' => $user->email,
      'status' => self::getStatus($request)

    ]);

    return parent::getPanel('Cadastrar Usuário', $content, 'users');
  }

  /**
   * Salva as edições de um usuário 
   *
   * @param  Request $request
   * @param  int $id
   * @return void
   */
  public static function editUser($request, $id)
  {
    $user = EntityUser::getUserById($id);

    // Valida instância
    if (!$user instanceof EntityUser) {
      $request->getRouter()->redirect('/admin/users');
    }

    $postVars = $request->getPostVars();
    $email = $postVars['email'] ? trim($postVars['email']) : $user->email;

    $userEmail = EntityUser::getUserByEmail($email);

    // Valida se o email já está em uso por outro usuário
    if ($userEmail instanceof EntityUser && $id != $userEmail->id) {
      $request->getRouter()->redirect("/admin/users/${id}/edit?status=duplicated");
    }

    $user->nome = $postVars['name'] ? trim($postVars['name']) : $user->nome;
    $user->email = $email;
    $user->senha = EntityUser::generatePassword($postVars['password'] ?? $user->senha);
    $user->updateUser();

    $request->getRouter()->redirect("/admin/users/{$user->id}/edit?status=updated");
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
        return Alert::getSuccess('Usuário <b>criado<b/> com sucesso!');
      case 'updated':
        return Alert::getSuccess('Usuário <b>atualizado</b> com sucesso!');
      case 'deleted':
        return Alert::getSuccess('Usuário <b>excluído</b> com sucesso!');
      case 'duplicated':
        return Alert::getError('O e-mail informado já está em uso por outro usuário!');
      default:
        return '';
    }
  }

  /**
   * Retorna o formulário de exclusão de um usuário
   *
   * @param  Request $request
   * @param int $id
   * @return string
   */
  public static function getUserExclusionForm($request, $id)
  {
    $user = EntityUser::getUserById($id);

    // Valida se existe uma instância de usuário
    if (!$user instanceof EntityUser) {
      $request->getRouter()->redirect('/admin/users');
    }

    // Conteúdo formulário
    $content = View::render('Admin/Modules/Users/exclusion', [
      'title' => 'Excluir usuário',
      'name' => $user->nome,
      'email' => $user->email,

    ]);

    return parent::getPanel('Excluir usuário', $content, 'users');
  }

  /**
   * Excluir um usuário
   *
   * @param  Request $request
   * @param  int $id
   * @return void
   */
  public static function deleteUser($request, $id)
  {
    $user = EntityUser::getUserById($id);

    // Valida se existe uma instância de usuário
    if (!$user instanceof EntityUser) {
      $request->getRouter()->redirect('/admin/users');
    }

    // Exclui o usuário
    $user->deleteUser();

    $request->getRouter()->redirect("/admin/users?status=deleted");
  }
}

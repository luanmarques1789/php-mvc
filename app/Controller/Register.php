<?php

namespace App\Controller;

use App\Http\Request;
use App\Utils\View;
use App\Models\Entities\User as EntityUser;
use App\Session\Admin\Login as LoginSession;

class Register extends Page
{
  /**
   * Renderiza a página de cadastro de usuário
   *
   * @param  Request $request
   * @param  string $errorMessage
   * @return string
   */
  public static function getRegister($request, $errorMessage = null)
  {
    $content = View::render('Pages/Register/register', [
      'status' => !is_null($errorMessage) ? Alert::getError($errorMessage) : ''
    ]);

    return parent::getPage('Cadastro', $content);
  }

  /**
   * registerUser
   *
   * @return mixed
   */
  public static function registerUser($request)
  {
    $postVars = $request->getPostVars();

    $email = $postVars['email'] ? trim($postVars['email']) : '';
    $password = $postVars['password'] ?? '';

    // Busca usuário pelo e-mail
    $userEmail = EntityUser::getUserByEmail($email);

    // Autenticação email e senha de usuário
    if ($userEmail instanceof EntityUser) {
      return self::getRegister($request, 'Email inserido já está em uso');
    }

    $user = new EntityUser();
    $user->nome = trim($postVars['name']);
    $user->email = $email;
    $user->senha = EntityUser::generatePassword($password);
    $user->register();

    // Cria sessão de login
    LoginSession::login($user);

    // Redireciona o usuário para a home do admin
    $request->getRouter()->redirect('/admin');
  }
}

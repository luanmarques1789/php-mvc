<?php

namespace App\Controller;

use App\Controller\Page;
use App\Controller;
use App\Http\Request;
use App\Models\Entities\User;
use App\Session\Admin\Login as LoginSession;
use App\Utils\View;

class Login extends Page
{

  /**
   * Renderiza a página de login
   *
   * @param  Request $request
   * @param  string $errorMessage
   * @return string
   */
  public static function getLogin($request, $errorMessage = null)
  {
    $content = View::render('Pages/Login/login', [
      'status' => !is_null($errorMessage) ? Alert::getError($errorMessage) : ''
    ]);

    return parent::getPage('Login', $content);
  }

  /**
   * Definir login do usuário 
   *
   * @param  Request $request
   * @return
   */
  public static function setLogin($request)
  {
    $postVars = $request->getPostVars();
    $email = $postVars['email'] ?? '';
    $password = $postVars['password'] ?? '';

    // Busca usuário pelo e-mail
    $user = User::getUserByEmail($email);

    // Autenticação email e senha de usuário
    if (!$user instanceof User || !password_verify(SALT . $password, $user->senha)) {
      return self::getLogin($request, 'Email ou senha inválidos');
    }

    // Cria sessão de login
    LoginSession::login($user);

    // Redireciona o usuário para a home do admin
    $request->getRouter()->redirect('/admin');
  }

  /**
   * Deslogar usuário
   *
   * @param  Request $request
   * @return void
   */
  public static function setLogout($request)
  {
    LoginSession::logout();

    $request->getRouter()->redirect('/login');
  }
}

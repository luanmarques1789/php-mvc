<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;
use App\Session\Admin\Login as LoginSession;

class RequireAdminLogin
{

  /**
   * Executar as ações do middleware
   *
   * @param  Request $request
   * @param  Closure $next
   * @return Response
   */
  public function handle($request, $next)
  {
    // Verifica se o usuário está logado
    if (!LoginSession::isLogged()) {
      // Se não estiver logado, redireciona o cliente para a tela de login
      $request->getRouter()->redirect('/admin/login');
    }

    return $next($request);
  }
}

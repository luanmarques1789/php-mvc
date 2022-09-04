<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;
use App\Session\Admin\Login as LoginSession;

class RequireAdminLogout
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
    if (LoginSession::isLogged()) {
      // Se já estiver logado, redireciona para a página admin
      $request->getRouter()->redirect('/admin');
    }

    return $next($request);
  }
}

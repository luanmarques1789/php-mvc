<?php

namespace App\Http\Middlewares;

use App\Http\Request;
use App\Http\Response;
use Closure;

class Maintenance
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
    // Verifica o estado de manutenção da página
    if (MAINTENANCE == 'true') {
      throw new \Exception("Página em manutenção. Tente mais tarde");
    }

    // Executa o próximo nível de middleware
    return $next($request);
  }
}

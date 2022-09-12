<?php

namespace App\Http\Middlewares;

use App\Http\Request;
use App\Http\Response;
use Closure;

class Queue
{
  /**
   * Middlewares padrões para todas as rotas
   * @var array
   */
  private static $defaultMiddlewares = [];

  /**
   * Fila de middlewares a serem 
   *
   * @var array
   */
  private $middlewares = [];

  /**
   * Função de execução do controlador
   *
   * @var Closure
   */
  private $controller;

  /**
   * Argumentos da função do controlador
   *
   * @var array
   */
  private $controllerArgs = [];


  /**
   * Mapeamento de middlewares
   *
   * @var array
   */
  private static $map = [];

  /**
   * Construtor da classe de fila de middlewares
   *
   * @param  array $middlewares
   * @param  Closure $controller
   * @param  array $controllerArgs
   * @return void
   */
  public function __construct($middlewares, $controller, $controllerArgs)
  {
    $this->middlewares = array_merge(self::$defaultMiddlewares, $middlewares);
    $this->controller = $controller;
    $this->controllerArgs = $controllerArgs;
  }

  /**
   * Executar o próximo nível da fila de middlewares
   *
   * @param Request $request
   * @return Response
   */
  public function next($request)
  {
    if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

    // Deslocando o primeiro middleware do array para a variável
    $middleware = array_shift($this->middlewares);

    // Verificando se o middleware existe
    if (!isset(self::$map[$middleware])) {
      throw new \Exception("Problemas ao processar o middleware da requisição", 500);
    }

    $queue = $this;
    $next = function ($request) use ($queue) {
      return $queue->next($request);
    };

    //
    return (new self::$map[$middleware])->handle($request, $next);
  }

  /**
   * Definir o mapeamento de middlewares
   *
   * @param  array $map
   * @return void
   */
  public static function setMap($map)
  {
    self::$map = $map;
  }

  /**
   * Configura os middlewares padrões para todas as rotas da aplicação
   *
   * @param  array $defaultMiddlewares
   * @return void
   */
  public static function setDefaultMiddlewares($defaultMiddlewares)
  {
    self::$defaultMiddlewares = $defaultMiddlewares;
  }
}

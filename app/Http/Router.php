<?php

namespace App\Http;

use \Closure;
use Exception;

class Router
{
  /**
   * URL completa do projeto 
   *
   * @var string
   */
  private $url = '';

  /**
   * Prefixo de todas as rotas
   *
   * @var string
   */
  private $prefix = '';

  /**
   * Índice de rotas
   *
   * @var array
   */
  private $routes = [];

  /**
   * Instância (objeto) da classe Request
   *
   * @var Request
   */
  private $request;

  public function __construct($url)
  {
    $this->url = $url;
    $this->request = new Request();
    self::setPrefix();
  }


  /**
   * Definir prefixo das rotas
   *
   * @return void
   */
  private function setPrefix()
  {
    $parseUrl = parse_url($this->url);

    // Configurando o prefixo
    $this->prefix = $parseUrl['path'] ?? '';
  }

  /**
   * Adicionar rota
   *
   * @param  string $method
   * @param  string $route
   * @param  array $params
   * @return void
   */
  private function addRoute($method, $route, $params = [])
  {
    // Validação dos parâmetros
    foreach ($params as $key => $value) {
      if ($value instanceof Closure) {
        $params['controller'] = $value;
        unset($params[$key]);
      }
    }

    // Padrão de validação do URL
    $routePattern = '/^' . str_replace('/', '\/', $route) . '$/';

    // Adiciona a rota
    $this->routes[$routePattern][$method] = $params;
  }

  /**
   * Definir uma rota de GET
   *
   * @param  string $route
   * @param  array $params
   * @return void
   */
  public function get($route, $params = [])
  {
    $this->addRoute('GET', $route, $params);
  }

  /**
   * Definir uma rota de POST
   *
   * @param  string $route
   * @param  array $params
   * @return void
   */
  public function post($route, $params = [])
  {
    $this->addRoute('POST', $route, $params);
  }

  /**
   * Definir uma rota de PUT
   *
   * @param  string $route
   * @param  array $params
   * @return void
   */
  public function put($route, $params = [])
  {
    return $this->addRoute('PUT', $route, $params);
  }

  /**
   * Definir uma rota de DELETE
   *
   * @param  string $route
   * @param  array $params
   * @return void
   */
  public function delete($route, $params = [])
  {
    return $this->addRoute('DELETE', $route, $params);
  }


  /**
   * Retorna o URI sem o prefixo da rota
   *
   * @return string
   */
  private function getUri()
  {
    $uri = $this->request->getUri();

    // Fatia o prefixo do URI, caso exista
    $explodedUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
    return end($explodedUri);
  }

  /**
   * Retorna dados da rota atual
   *
   * @return array
   */
  private function getRoute()
  {
    $uri = $this->getUri();
    $httpMethod = $this->request->getHttpMethod();

    // Validação das rotas
    foreach ($this->routes as $routePattern => $method) {
      // Verifica se o URI bate com o padrão de rota
      if (preg_match($routePattern, $uri)) {
        // Verifica o método HTTP 
        if ($method[$httpMethod]) {
          return $method[$httpMethod];
        }

        throw new Exception("Método não permitido", 405);
      }
    }

    // URL não encontrado
    throw new Exception("URL não encontrado", 404);
  }

  /**
   * Executar a rota atual
   *
   * @return Response
   */
  public function runRoute()
  {
    try {
      $route = $this->getRoute();

      if (!isset($route['controller'])) {
        throw new Exception("O URL não pôde ser processado", 500);
      }

      $args = [];
      return call_user_func_array($route['controller'], $args);
    } catch (Exception $error) {
      return new Response($error->getCode(), $error->getMessage());
    }
  }
}

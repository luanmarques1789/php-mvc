<?php

namespace App\Http;


/**
 * Classe de requisição de rotas.
 */
class Request
{

  /**
   * Instância da classe Router
   *
   * @var Router
   */
  private $router;

  /**
   * Método HTTP da requisição.
   *
   * @var string
   */
  private $httpMethod;


  /**
   * URI da página.
   *
   * @var string
   */
  private $uri;


  /**
   * Parâmetros do URL.
   *
   * @var array
   */
  private $queryParams = [];

  /**
   * Variáveis recebidas no POST da página
   *
   * @var array
   */
  private $postVars = [];

  /**
   * Cabeçalho da requisição.
   *
   * @var array
   */
  private $headers = [];



  /**
   * Instanciar request
   *
   * @param Router Instância do Router
   * @return void
   */
  public function __construct($router)
  {
    $this->router = $router;
    $this->headers = getallheaders();
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    self::setUri();
  }

  /**
   * Retorna a instância da classe Router utilizada pelo request
   *
   * @return Router
   */
  public function getRouter()
  {
    return $this->router;
  }

  /**
   * Retorna o método HTTP da requisição.
   *
   * @return string
   */
  public function getHttpMethod()
  {
    return $this->httpMethod;
  }

  /**
   * Retorna o URI da requisição.
   *
   * @return string
   */
  public function getUri()
  {
    return $this->uri;
  }

  /**
   * Definir URI
   *
   * @return void
   */
  private function setUri()
  {
    // URI completo (com parâmetros)
    $fullUri = $_SERVER['REQUEST_URI'] ?? '';

    // Removendo parâmetros do URI
    $this->uri = explode('?', $fullUri)[0];
  }


  /**
   * Retorna os parâmetros (GET) do URL.
   *
   * @return array
   */
  public function getQueryParams()
  {
    return $this->queryParams;
  }

  /**
   * Retorna as variáveis recebidas no POST da página.
   *
   * @return array
   */
  public function getPostVars()
  {
    return $this->postVars;
  }

  /**
   * Retorna o cabeçalho da requisição.
   *
   * @return array
   */
  public function getHeaders()
  {
    return $this->headers;
  }
}

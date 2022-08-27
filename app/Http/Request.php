<?php

namespace App\Http;


/**
 * Classe de requisição de rotas.
 */
class Request
{

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
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $this->headers = getallheaders();
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
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

<?php

namespace App\Utils;

class View
{

  /**
   * Variáveis padrões da View
   * @var array
   */
  private static $vars = [];

  /**
   * Definir dados padrões da classe
   *  
   * @param array $vars 
   * @return void
   */
  public static function init($vars = [])
  {
    self::$vars = $vars;
  }


  /**
   * Método responsável por renderizar o conteúdo de uma view substituindo as variáveis contidas.
   * @param string $view Nome da view a ser renderizada.
   * @param array $vars Variáveis de conteúdo dinâmico.
   * @return string Conteúdo da view renderizada.
   */
  public static function render($view, $vars = [])
  {
    // Conteúdo cru
    $contentView = self::getContentView($view);

    // União de variáveis da View
    $vars = array_merge(self::$vars, $vars);

    // Chaves do array de variáveis
    $keys = array_keys($vars);
    $keys = array_map(fn ($item) => '{{' . $item . '}}', $keys);

    // Retorna o conteúdo da view renderizado
    return str_replace($keys, array_values($vars), $contentView);
  }

  /**
   * Método responsável por retornar o conteúdo cru de uma view.
   */
  private static function getContentView($view)
  {
    $file = __DIR__ . '/../../src/view/' . $view . '.html';
    return file_exists($file) ? file_get_contents($file) : '';
  }
}

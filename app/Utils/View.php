<?php

namespace App\Utils;

class View
{
  /**
   * Método responspável por renderizar o conteúdo de uma view substituindo as variáveis contidas.
   * @param string $view Nome da view a ser renderizada.
   * @param (int|string)[] $vars Variáveis de conteúdo dinâmico.
   * @return string Conteúdo da view renderizada.
   */
  public static function render($view, $vars = [])
  {
    // Conteúdo cru
    $contentView = self::getContentView($view);

    // Chaves do array de variáveis
    $keys = array_keys($vars);
    $keys = array_map(fn ($item) => '{{' . $item . '}}', $keys);

    // echo '<pre>';
    // print_r($keys);
    // echo '</pre>';

    // Retorna o conteúdo da view renderizado
    return str_replace($keys, array_values($vars), $contentView);
  }

  /**
   * Método responsável por retornar o conteúdo cru de uma view.
   */
  private static function getContentView($view)
  {
    $file = __DIR__ . '/../../src/view/pages/' . $view . '.html';
    return file_exists($file) ? file_get_contents($file) : '';
  }
}

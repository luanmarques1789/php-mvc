<?php

namespace App\Models\Entities;

use PDOStatement;
use WilliamCosta\DatabaseManager\Database;

class Testimony
{

  /**
   * ID (identificador) do depoimento 
   *
   * @var integer
   */
  public $id;

  /**
   * Nome do usuário o qual fez o depoimento 
   *
   * @var string
   */
  public $name;

  /**
   * Mensagem do depoimento
   *
   * @var string
   */
  public $message;

  /**
   * Data de publicação
   *
   * @var string
   */
  public $date;

  /**
   * Cadastrar a instância atual (depoimento do usuário) para o banco de dados
   *
   * @return boolean Retorna verdadeiro caso a cadastro seja bem sucedido, caso contrário, falso.
   */
  public function register()
  {
    $this->date = date('Y-m-d H:i:s');

    // Inserindo depoimento no banco de dados
    $this->id = (new Database('depoimentos'))->insert([
      'nome' => $this->name,
      'mensagem' => $this->message,
      'data' => $this->date
    ]);

    return true;
  }

  /**
   * Obter depoimentos
   *
   * @param  string $where Condição para fazer filtragem de depoimentos
   * @param  string $order Ordem de exibição dos depoimentos
   * @param  string $limit Limite de linhas (registros) do banco de dados
   * @return PDOStatement
   */
  public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
  {
    return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
  }
}

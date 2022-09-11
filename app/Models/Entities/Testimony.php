<?php

namespace App\Models\Entities;

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
  public $nome;

  /**
   * Mensagem do depoimento
   *
   * @var string
   */
  public $mensagem;

  /**
   * Data de publicação
   *
   * @var string
   */
  public $data;

  /**
   * Cadastrar a instância atual (depoimento do usuário) para o banco de dados
   *
   * @return boolean Retorna verdadeiro caso a cadastro seja bem sucedido, caso contrário, falso.
   */
  public function register()
  {
    // Definindo timezone 
    date_default_timezone_set('America/Sao_Paulo');
    // Formatando data
    $this->data = date('Y-m-d H:i:s');

    // Inserindo depoimento no banco de dados
    $this->id = (new Database('depoimentos'))->insert([
      'nome' => $this->nome,
      'mensagem' => $this->mensagem,
      'data' => $this->data
    ]);

    return true;
  }

  /**
   * Atualiza os dados do banco com os dados da instância atual
   *
   * @return bool
   */
  public function updateTestimony()
  {
    // Atualizando depoimento no banco de dados
    return (new Database('depoimentos'))->update(where: "id = {$this->id}", values: [
      'nome' => $this->nome,
      'mensagem' => $this->mensagem,
    ]);
  }

  /**
   * Exclui um depoimento no banco de dados
   *
   * @return bool
   */
  public function deleteTestimony()
  {
    // Excluindo depoimento no banco de dados
    return (new Database('depoimentos'))->delete(where: "id = {$this->id}");
  }

  /**
   * Obter depoimentos
   *
   * @param  string $where Condição para fazer filtragem de depoimentos
   * @param  string $order Ordem de exibição dos depoimentos
   * @param  string $limit Limite de linhas (registros) do banco de dados
   * @param  string $fields Campos (atributos) da tabela
   * @return mixed
   */
  public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
  {
    return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
  }

  /**
   * Obtém um depoimento com base em seu ID
   * @param int $id Identificador (id) do depoimento
   * @return Testimony
   */
  public static function getTestimonyById($id)
  {
    return self::getTestimonies(where: "id = ${id}")->fetchObject(self::class);
  }
}

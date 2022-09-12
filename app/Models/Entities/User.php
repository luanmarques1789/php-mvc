<?php

namespace App\Models\Entities;

use WilliamCosta\DatabaseManager\Database;

class User
{
  /**
   * Id do usuário
   *
   * @var mixed
   */
  public $id;

  public $nome;

  /**
   * E-mail do usuário
   *
   * @var mixed
   */
  public $email;

  /**
   * Senha do usuário
   *
   * @var mixed
   */
  public $senha;

  /**
   * Cadastra um novo usuário no banco de dados 
   *
   * @return boolean
   */
  public function register()
  {
    $this->id = (new Database('usuarios'))->insert([
      'nome' => $this->nome,
      'email' => $this->email,
      'senha' => $this->senha
    ]);

    return true;
  }

  /**
   * Atualiza os dados do banco com os dados da instância atual
   *
   * @return bool
   */
  public function updateUser()
  {
    // Atualizando registro de usuário no banco de dados
    return (new Database('usuarios'))->update(where: "id = {$this->id}", values: [
      'nome' => $this->nome,
      'email' => $this->email,
      'senha' => $this->senha
    ]);
  }

  /**
   * Obter usuário via e-mail
   *
   * @param  string $email
   * @return User
   */
  public static function getUserByEmail($email)
  {
    return (new Database('usuarios'))->select(where: "email = '$email' ")->fetchObject(self::class);
  }

  /**
   * Obter usuário via ID
   *
   * @param  int $id ID (identificador) do usuário
   * @return User
   */
  public static function getUserById($id)
  {
    return (new Database('usuarios'))->select(where: "id = '$id' ")->fetchObject(self::class);
  }


  /**
   * Obter registro de usuários
   *
   * @param  mixed $where
   * @param  mixed $order
   * @param  mixed $limit
   * @param  mixed $fields
   * @return mixed
   */
  public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
  {
    return (new Database('usuarios'))->select($where, $order, $limit, $fields);
  }

  /**
   * Exclui um usuário no banco de dados
   *
   * @return mixed
   */
  public function deleteUser()
  {
    // Excluindo usuário no banco de dados
    return (new Database('usuarios'))->delete(where: "id = {$this->id}");
  }

  /**
   * Gera uma nova senha 
   *
   * @param  string $password
   * @return string Retorna a nova senha
   */
  public static function generatePassword($password)
  {
    return password_hash(SALT . $password, PASSWORD_DEFAULT);
  }
}

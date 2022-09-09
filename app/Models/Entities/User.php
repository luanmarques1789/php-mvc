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
   * Obter usuário via e-mail
   *
   * @param  string $email
   * @return User
   */
  public static function getUserByEmail($email)
  {
    return (new Database('usuarios'))->select(where: "email = '$email' ")->fetchObject(self::class);
  }
}

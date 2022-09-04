CREATE DATABASE IF NOT EXISTS `php_mvc`;

USE `php_mvc`;

CREATE TABLE IF NOT EXISTS `depoimentos` (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  mensagem TEXT NOT NULL,
  data TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS `usuarios` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
);
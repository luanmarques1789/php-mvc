<?php

include_once __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!defined('URL'))
  /** PROJECT URL */
  define('URL', $_ENV['URL']);

if (!defined('DB_USER'))
  /** DATABASE'S USER */
  define('DB_USER', $_ENV['DB_USER']);

if (!defined('DB_PASSWORD'))
  /** DATABASE'S USER PASSWORD */
  define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

if (!defined('DB_NAME'))
  /** DATABASE'S NAME */
  define('DB_NAME', $_ENV['DB_NAME']);

if (!defined('DB_HOST'))
  /** DATABASE'S HOST */
  define('DB_HOST', $_ENV['DB_HOST']);

if (!defined('DB_PORT'))
  /** DATABASE'S PORT */
  define('DB_PORT', $_ENV['DB_PORT']);

if (!defined('MAINTENANCE'))
  /** PAGE MAINTENANCE */
  define('MAINTENANCE', $_ENV['MAINTENANCE']);

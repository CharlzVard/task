<?php

namespace App\Core;

class DB
{
  private $db;
  public function __construct()
  {
    $paramsPath = dirname(__DIR__, 2) . '/config/db.php';
    $params = include($paramsPath);
    $dsn = "mysql:host={$params['host']};dbname={$params['name']}";
    try {
      $this->db = new \PDO($dsn, $params['user'], $params['pass']);
    } catch (\PDOException $e) {
      die('Подключение не удалось: ' . $e->getMessage());
    }
    $this->db->exec("set names utf8");
  }

  public function getDb()
  {
    if ($this->db instanceof \PDO) {
      return $this->db;
    }
  }
}

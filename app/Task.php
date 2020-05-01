<?php

namespace App;

use App\Core\Model as Model;
use App\Core\DB as DB;

class Task extends Model
{
  private $dbclass;
  private $pdo;
  private $lastCount;

  public function __construct()
  {
    $this->dbclass = new DB();
    $this->pdo = $this->dbclass->getDb();
  }

  public function get_tasks($data)
  {
    $sortBy = $data["sortby"];
    $order  = $data['order'];
    $limit  = $data['limit'];
    $offset = $data['offset'];
    try {
      $tasks = array();
      $sql = "SELECT * FROM `tasks`
              ORDER BY $sortBy $order
              LIMIT :limit OFFSET :offset";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
      $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
      $stmt->execute();

      if (($stmt->execute()) && ($stmt->rowCount() > 0)) {
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
          $tasks[] = $row;
        }
      } else {
        $tasks = false;
      }
      $this->lastCount = $this->foundRows();
    } catch (\PDOException $e) {
      throw new \Exception('Ошибка при получении задач', 0, $e);
    }
    return $tasks;
  }

  public function getTaskById($id)
  {
    try {
      $tasks = array();
      $sql = "SELECT * FROM `tasks`
              WHERE `id`= :id
              LIMIT 1";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
      $stmt->execute();

      if (($stmt->execute()) && ($stmt->rowCount() > 0)) {
        $task = $stmt->fetch(\PDO::FETCH_ASSOC);
      } else {
        $task = false;
      }
      $this->lastCount = $this->foundRows();
    } catch (\PDOException $e) {
      throw new \Exception('Ошибка при получении задачи', 0, $e);
    }
    return $task;
  }

  public function getCount()
  {
    $count = 0;
    try {
      $tasks = array();
      $sql = "SELECT * FROM `tasks`";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();

      if (($stmt->execute()) && ($stmt->rowCount() > 0)) {
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
          $tasks[] = $row;
        }
      } else {
        $tasks = false;
      }
      $this->lastCount = $this->foundRows();
      if ($tasks) $count = count($tasks);
    } catch (\PDOException $e) {
      throw new \Exception('Ошибка при получении задач', 0, $e);
    }
    return $count;
  }

  public function foundRows()
  {
    try {
      $count = false;
      $sql = 'SELECT FOUND_ROWS()';
      $stmt = $this->pdo->prepare($sql);
      if ($stmt->execute()) {
        if ($stmt->rowCount() == 0) {
          $count = false;
        }
        $row = $stmt->fetch(\PDO::FETCH_NUM);
        $count = $row[0];
      } else {
        $count = false;
      }
    } catch (\PDOException $e) {
      throw new \Exception('Ошибка при получении числа задач', 0, $e);
    }
    return $count;
  }

  public function storeTask($name, $email, $text)
  {
    try {
      $sql = 'INSERT INTO `tasks`(`user`, `email`, `text`)
                    VALUES (:user, :email, :text)';
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user', $name, \PDO::PARAM_STR_CHAR);
      $stmt->bindParam(':email', $email, \PDO::PARAM_STR_CHAR);
      $stmt->bindParam(':text', $text, \PDO::PARAM_STR_CHAR);

      $result = $stmt->execute();

      if (($result !== false) and ($this->pdo->lastInsertId() !== 0)) {
        $id = $this->pdo->lastInsertId();
      }
      $this->lastCount = $this->foundRows();
    } catch (\PDOException $e) {
      throw new \Exception('Ошибка при получении задач', 0, $e);
    }
    return $id;
  }

  public function updateTask($id, $name, $email, $text, $iscompleted, $isedited)
  {
    try {
      $sql = 'UPDATE `tasks` SET 
      `user` = :user,
      `email` = :email,
      `text` = :text,
      `is_completed`= :iscompleted,
      `is_edited` = :isedited
      WHERE `id` = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
      $stmt->bindParam(':user', $name, \PDO::PARAM_STR_CHAR);
      $stmt->bindParam(':email', $email, \PDO::PARAM_STR_CHAR);
      $stmt->bindParam(':text', $text, \PDO::PARAM_STR_CHAR);
      $stmt->bindParam(':iscompleted', $iscompleted, \PDO::PARAM_INT);
      $stmt->bindParam(':isedited', $isedited, \PDO::PARAM_INT);

      $result = $stmt->execute();

      if (($result === false)) {
        $id = "0";
      }
      $this->lastCount = $this->foundRows();
    } catch (\PDOException $e) {
      throw new \Exception('Ошибка при получении задач', 0, $e);
    }
    return $id;
  }
}

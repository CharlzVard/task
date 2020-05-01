<?php

namespace App;

use App\Core\Model as Model;
use App\Core\DB as DB;

class User extends Model
{
  public function __construct()
  {
    $this->dbclass = new DB();
    $this->pdo = $this->dbclass->getDb();
  }

  public function checkCredentials($name, $pass)
  {
    $result = false;
    try {
      $sql = "SELECT * FROM `users`
              WHERE `name`= :name
              LIMIT 1";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':name', $name, \PDO::PARAM_INT);
      $stmt->execute();

      if (($stmt->execute()) && ($stmt->rowCount() > 0)) {
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
      } else {
        $user = false;
      }
      if (isset($user["pass"]) && md5($pass) == $user["pass"]) {
        $result = true;
        $_SESSION['auth_user'] = $user["name"];
        $_SESSION['auth_email'] = $user["email"];
        $_SESSION['auth_isadmin'] = $user["is_admin"];
      } else {
        unset($_SESSION['auth_user']);
        unset($_SESSION['auth_email']);
        unset($_SESSION['auth_isadmin']);
      }
    } catch (\PDOException $e) {
      throw new \Exception('Ошибка при получении пользователя', 0, $e);
    }
    return $result;
  }
}

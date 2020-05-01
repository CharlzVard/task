<?php

namespace App\Controllers;

use App\Core\Controller as Controller;
use App\Core\View as View;
use App\User as User;
use App\Core\DB as DB;

class LoginController extends Controller
{

  function __construct()
  {
    $this->user = new User();
    $this->view = new View();
    $this->pdo = new DB();
  }

  function index()
  {
    $this->view->generate('login.php', 'layouts/layout.php');
  }

  function login()
  {
    $name = $_POST['name'] ?? $_SESSION['name'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $data = [];


    if ($this->user->checkCredentials($name, $pass)) {
      unset($_SESSION['name']);
      return header("Location: /");
    } else {
      $data["error"] = "Не совпадают логин и пароль";
      $_SESSION['name'] = $_POST['name'];
      $this->view->generate('login.php', 'layouts/layout.php', $data);
    }
  }

  function logout()
  {
    unset($_SESSION['auth_user']);
    unset($_SESSION['auth_email']);
    unset($_SESSION['auth_isadmin']);
    return header("Location: /");
  }
}

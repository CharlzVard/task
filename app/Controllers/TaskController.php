<?php

namespace App\Controllers;

use App\Core\Controller as Controller;
use App\Core\View as View;
use App\Task;

class TaskController extends Controller
{

  function __construct()
  {
    $this->model = new Task();
    $this->view = new View();
  }

  function index($req)
  {
    $page = $req['page'] ?? 1;

    if (isset($req['sortby']) && $req['sortby'] == "name") $sortby = "user";
    if (isset($req['sortby']) && $req['sortby'] == "email") $sortby = "email";
    if (isset($req['sortby']) && $req['sortby'] == "is_completed") $sortby = "is_completed";

    if (isset($req['order']) && $req['order'] == "asc") $order = "asc";
    if (isset($req['order']) && $req['order'] == "desc") $order = "desc";

    $sortby = $sortby ?? $_SESSION['sortby'] ?? 'user';
    $order = $order ?? $_SESSION['order'] ?? 'asc';

    $_SESSION['sortby'] = $sortby;
    $_SESSION['order'] = $order;

    $search = [
      'sortby' => $sortby,
      'order' => $order,
      'limit' => '3',
      'offset' => ($page - 1) * 3
    ];

    $data['count'] = $this->model->getCount();
    $data['tasks'] = $this->model->get_tasks($search);
    $this->view->generate('task.index.php', 'layouts/layout.php', $data);
  }

  function add()
  {
    $this->view->generate('task.add.php', 'layouts/layout.php');
  }

  function store()
  {
    $user = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $text = $_POST['text'] ?? null;
    $data = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $data['errors']['email'] = 'Email указан неверно';
    if (!$user) $data['errors']['name'] = 'Не указано имя пользователя';
    if (!$text) $data['errors']['text'] = 'Не указан текст задачи';

    if (!isset($data['errors'])) {
      $id = $this->model->storeTask($user, $email, $text);
      $data['success'] = 'Задача ' . $id . ' добавлена!';
      unset($_SESSION['name']);
      unset($_SESSION['email']);
      unset($_SESSION['text']);
    } else {
      $_SESSION['name'] = $user;
      $_SESSION['email'] = $email;
      $_SESSION['text'] = $text;
    }

    $this->view->generate('task.add.php', 'layouts/layout.php', $data);
  }

  public function edit($req)
  {
    $id = $req['id'] ?? null;
    $data = [];
    if ($id) $task = $this->model->getTaskById($id);
    $data['task'] = $task;
    if (isset($task['id']))
      $this->view->generate('task.edit.php', 'layouts/layout.php', $data);
    else
      return  new \Exception('Ошибка при получении задачи');
  }


  public function update()
  {
    if (isset($_SESSION['auth_isadmin']) && $_SESSION['auth_isadmin'] == "1") {
      $id = $_POST['id'] ?? null;
      $user = $_POST['name'] ?? null;
      $email = $_POST['email'] ?? null;
      $text = $_POST['text'] ?? null;
      $iscompleted = null;
      if (isset($_POST['is_completed'])) $iscompleted = "1";
      $isedited = null;
      $data = [];

      $oldtask = $this->model->getTaskById($id);
      if ($oldtask['is_edited'] || $oldtask['text'] != $text) $isedited = "1";

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $data['errors']['email'] = 'Email указан неверно';
      if (!$user) $data['errors']['name'] = 'Не указано имя пользователя';
      if (!$text) $data['errors']['text'] = 'Не указан текст задачи';

      if (!isset($data['errors'])) {
        $id = $this->model->updateTask($id, $user, $email, $text, $iscompleted, $isedited);
        $data['success'] = 'Задача ' . $id . ' обновлена!';
        $data['task'] = $this->model->getTaskById($id);
      }
    } else {
      return header("Location: /login");
    }
    $this->view->generate('task.edit.php', 'layouts/layout.php', $data);
  }
}

<div class="container">
  <div class="row justify-content-end mb-3">
    <div class="col-lg-6 text-right">
      <form action="/" method="get">

        <div class="input-group">
          <select class="custom-select" id="sortby" name="sortby">
            <option value="name" <?php echo ($_SESSION['sortby'] == "name") ? 'selected' : '' ?>>По имени</option>
            <option value="email" <?php echo ($_SESSION['sortby'] == "email") ? 'selected' : '' ?>>По почте</option>
            <option value="is_completed" <?php echo ($_SESSION['sortby'] == "is_completed") ? 'selected' : '' ?>>По статусу</option>
          </select>
          <select class="custom-select" id="order" name="order">
            <option value="asc" <?php echo ($_SESSION['order'] == "asc") ? 'selected' : '' ?>>По возрастанию</option>
            <option value="desc" <?php echo ($_SESSION['order'] == "desc") ? 'selected' : '' ?>>По убыванию</option>
          </select>
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="submit">Применить</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">Имя пользователя</th>
          <th scope="col">E-mail</th>
          <th scope="col">Текст задачи</th>
          <th scope="col">Статус</th>
          <?php if (isset($_SESSION['auth_isadmin'])) echo '<th scope="col" class="text-right">Админка</th>'; ?>
        </tr>
      </thead>
      <tbody>
        <?php if ($data['tasks'] != false) : ?>
          <?php foreach ($data['tasks'] as $row) : ?>
            <tr>
              <th scope="row"><?php echo htmlspecialchars($row['user']); ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo htmlspecialchars($row['text'], ENT_QUOTES); ?></td>
              <td><?php
                  echo ($row['is_completed']) ? 'Выполнено' : 'Не выполнено';
                  echo ($row['is_edited']) ? '<br>Отредактировано администратором' : '';
                  ?>
              </td>
              <?php if (isset($_SESSION['auth_isadmin'])) echo '<td scope="col" class="text-right"><a href="/task/edit?id=' . $row['id'] . '" class="btn btn-sm btn-outline-info">Изменить</a></td>'; ?>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="5">
              <h5 class="text-center m-0">Задач пока нет</h5>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="row">
    <div class="col-12">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <?php
          if ($data['count'] > 3) {
            for ($i = 1; $i < ($data['count'] + 3) / 3; $i++) {
              echo '<li class="page-item ';
              echo ($_GET['page'] == $i || (!isset($_GET['page']) && $i == 1)) ? 'active' : '';
              echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
          }
          ?>
        </ul>
      </nav>
    </div>
  </div>
</div>
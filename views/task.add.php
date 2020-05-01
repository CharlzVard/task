<div class="container">
  <form action="/task/store" method="POST">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control <?php echo isset($data['errors']['email']) ? 'is-invalid' : ''; ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $_SESSION['email'] ?? $_SESSION['auth_email'] ?? '' ?>">
      <div class="invalid-feedback"><?php if (isset($data['errors']['email'])) echo $data['errors']['email']; ?></div>
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
      <label for="name">Имя пользователя</label>
      <input type="text" class="form-control <?php echo isset($data['errors']['name']) ? 'is-invalid' : ''; ?>" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter name" value="<?php echo $_SESSION['name'] ?? $_SESSION['auth_user'] ?? '' ?>">
      <div class="invalid-feedback"><?php if (isset($data['errors']['name'])) echo $data['errors']['name']; ?></div>
    </div>
    <div class="form-group">
      <label for="text">Текст задачи</label>
      <textarea class="form-control <?php echo isset($data['errors']['text']) ? 'is-invalid' : ''; ?>" name="text" id="text" rows="3" aria-describedby="textHelp" placeholder="Enter task"><?php echo $_SESSION['text'] ?? '' ?></textarea>
      <div class="invalid-feedback"><?php if (isset($data['errors']['text'])) echo $data['errors']['text']; ?></div>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
  </form>
  <?php
  if (isset($data['success'])) {
    echo '<div class="alert alert-success mt-3" role="alert">Задача добавлена!</div>';
  }
  ?>
</div>
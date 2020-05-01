<div class="container">
  <?php if (isset($data['task'])) : ?>
    <form action="/task/update" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control <?php echo isset($data['errors']['email']) ? 'is-invalid' : ''; ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $data['task']['email'] ?? '' ?>">
        <div class="invalid-feedback"><?php if (isset($data['errors']['email'])) echo $data['errors']['email']; ?></div>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="name">Имя пользователя</label>
        <input type="text" class="form-control <?php echo isset($data['errors']['name']) ? 'is-invalid' : ''; ?>" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter name" value="<?php echo $data['task']['user'] ?? '' ?>">
        <div class="invalid-feedback"><?php if (isset($data['errors']['name'])) echo $data['errors']['name']; ?></div>
      </div>
      <div class="form-group">
        <label for="text">Текст задачи</label>
        <textarea class="form-control <?php echo isset($data['errors']['text']) ? 'is-invalid' : ''; ?>" name="text" id="text" rows="3" aria-describedby="textHelp" placeholder="Enter task"><?php echo $data['task']['text'] ?? '' ?></textarea>
        <div class="invalid-feedback"><?php if (isset($data['errors']['text'])) echo $data['errors']['text']; ?></div>
      </div>
      <div class="form-group">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="customCheck1" name="is_completed" <?php if (isset($data['task']) && isset($data['task']['is_completed'])) echo ($data['task']['is_completed']) ? 'checked' : '' ?>>
          <label class="custom-control-label" for="customCheck1">Выполнено</label>
        </div>
      </div>
      <input type="hidden" name="id" value="<?php if (isset($data['task']) && isset($data['task']['id'])) echo $data['task']['id'] ?? '' ?>">
      <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
  <?php endif; ?>
  <?php
  if (isset($data['success'])) {
    echo '<div class="alert alert-success mt-3" role="alert">' . $data['success'] . '</div>';
  }
  if (isset($data['error'])) {
    echo '<div class="alert alert-danger mt-3" role="alert">' . $data['error'] . '</div>';
  }
  ?>
</div>
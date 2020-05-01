<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <form action="/login/login" method="POST">
        <div class="form-group">
          <label for="name">Имя</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Enter name" value="<?php echo $_SESSION['name'] ?? '' ?>">
        </div>
        <div class="form-group">
          <label for="pass">Пароль</label>
          <input type="password" class="form-control <?php echo (isset($data['error'])) ? 'is-invalid' : '' ?>" id="pass" name="pass" placeholder="Password">
          <div class="invalid-feedback"><?php if (isset($data['error'])) echo $data['error']; ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
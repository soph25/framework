<?php $this->layout('template', ['title' => 'Admin']) ?>

<div class="container">



<form action="/inscription" method="post">
<?php echo $this->csrf_input();?>  
<div class="form-group">
  <label for="username">Username</label>
  <input type="text" class="form-control" name="username" id="username" >
</div>
<?php if (isset($errors['username'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['username']->__toString();?>
</div>
<?php endif; ?>
<div class="form-group">
  <label for="email">Email</label>
  <input type="email" class="form-control" name="email" id="email" >
</div>
<?php if (isset($errors['email'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['email']->__toString();?>
</div>
<?php endif; ?>
<div class="form-group">
  <label for="password">Password</label>
  <input type="password" class="form-control" name="password" id="password" >
</div>
<?php if (isset($errors['password'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['password']->__toString();?>
</div>
<?php endif; ?>
<div class="form-group">
  <label for="password_confirm">Password confirm</label>
  <input type="password" class="form-control" name="password_confirm" id="password_confirm" >
</div>
<?php if (isset($errors['password'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['password']->__toString();?>
</div>
<?php endif; ?>
 <button class="btn btn-primary">S'inscrire</button>
</form>

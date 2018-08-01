<?php $this->layout('template', ['title' => 'Admin']) ?>

<form action="/login" method="post">
<?php echo $this->csrf_input();?>  
<div class="form-group">
  <label for="username">Username</label>
  <input type="text" class="form-control" name="username" id="username" >
</div>
<?php if(isset($errors['username'])): ?>
<div class="alert alert-danger">
<?php echo $errors['username']->__toString();?>
</div>
<?php endif; ?>
<div class="form-group">
  <label for="password">Password</label>
  <input type="password" class="form-control" name="password" id="password" >
</div>
<?php if(isset($errors['password'])): ?>
<div class="alert alert-danger">
<?php echo $errors['password']->__toString();?>
</div>
<?php endif; ?>
 <button class="btn btn-primary">Se connecter</button>
</form>

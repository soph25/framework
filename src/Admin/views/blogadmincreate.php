<?php $this->layout('template', ['title' => 'Admin']) ?>

<form action="/admin/posts/new" method="post" enctype="multipart/form-data">
<?php echo $this->csrf_input();?>  

<div class="row">
  <div class="col-md-4">
    
  <label for="name">Titre de l'article</label>
  <input type="text" class="form-control" name="name" id="name">
<?php if(isset($errors['name'])): ?>
<div class="alert alert-danger">
<?php echo $errors['name']->__toString();?>
</div>
<?php endif; ?>
  </div>
</div>


<div class="row">
    <div class="col-md-4">
    <?php if(isset($item->image)): ?>
      <img src="{{ item.thumb }}" alt="" style="width:100%;">
    <?php endif; ?>
   </div>
   <div class="col-md-4">
      <label for="image">image</label>
         <input type="file" id="image" name="image[]" class="form-control" >
<?php if(isset($errors['image'])): ?>
<div class="alert alert-danger">
<?php echo $errors['image']->__toString();?>
</div>
<?php endif; ?>
    </div>

    <div class="col-md-4">
    <label for="slug">Slug</label>
    <input type="text" class="form-control" name="slug" id="slug">
<?php if(isset($errors['slug'])): ?>
<div class="alert alert-danger">
<?php echo $errors['slug']->__toString();?>
</div>
<?php endif; ?>
     </div>

</div>
<div class="col-md-4">
  <label for="content">Contenu</label>
  <textarea class="form-control" name="content" id="content" rows="10"></textarea>
<?php if(isset($errors['content'])): ?>
<div class="alert alert-danger">
<?php echo $errors['content']->__toString();?>
</div>
<?php endif; ?>
</div>

<div class="col-md-4">
  <label for="date">Date</label>
  <input type="text" class="form-control" name="created_at" value="<?php echo date('Y-m-d H:i:s');?>">
  <input type="hidden" class="form-control" name="updated_at" value="<?php echo date('Y-m-d H:i:s');?>"> 
<?php if(isset($errors['created_at'])): ?>
<div class="alert alert-danger">
<?php echo $errors['created_at']->__toString();?>
</div>
<?php endif; ?>
</div>


 <button id="target2" class="btn btn-primary">Creer article</button>
</form>

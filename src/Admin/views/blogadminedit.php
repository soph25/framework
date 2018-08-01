<?php $this->layout('template', ['title' => 'Admin']) ?>

<form action="/admin/posts/<?php echo $item->id; ?>" method="post" enctype="multipart/form-data">
<?php echo $this->csrf_input();?>  
<div class="form-group">
  <label for="name">Titre de l'article</label>
  <input type="text" class="form-control" name="name" id="name" value="<?php echo $item->name;?>">
<?php if (isset($errors['name'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['name']->__toString();?>
</div>
<?php endif; ?>
  <input type="hidden" class="form-control" name="updated_at" value="<?php echo date('Y-m-d H:i:s');?>"> 
</div>
<div class="form-group">
  <label for="image">image</label>
<?php if (isset($item->image)) : ?>
          <p>
      
              <img src="<?= $item->getThumb();?>" alt="<?= $item->getImageUrl() ;?>" width="10%">
          </p>
<?php endif; ?>
          <input type="file" id="image" name="image[]"  value="<?php echo isset($item->image); ?>">
<?php if (isset($errors['image'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['image']->__toString();?>
</div>
<?php endif; ?>

</div>

<div class="form-group">
  <label for="slug">Titre de l'article</label>
  <input type="text" class="form-control" name="slug" id="slug" value="<?php echo $item->slug;?>">
<?php if (isset($errors['slug'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['slug']->__toString();?>
</div>
<?php endif; ?>
</div>
<div class="form-group">
  <label for="content">Contenu</label>
  <textarea class="form-control" name="content" id="content" rows="10"><?php echo $item->content;?></textarea>
<?php if (isset($errors['content'])) : ?>
<div class="alert alert-danger">
    <?php echo $errors['content']->__toString();?>
</div>
<?php endif; ?>
</div>
 <button id="target2" class="btn btn-primary">Mettre à jour</button>
</form>

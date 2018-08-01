<?php $this->layout('template', ['title' => 'Admin']) ?>

<h1>Admin</h1>

<?php if($this->getFlash('success')): ?>
<div class="alert alert-success">

<?=$this->getFlash('success')?>

</div>
<?php endif; ?> 

<table class="table table-striped">
    <thead>
    <tr>
      <td>Titre</td>
      <td>Actions</td>
    </tr>
    </thead>
    <tbody>

 
    <?php foreach ($items as $item): ?>
    <tr>
      <td><?= $item->name;?></td>
      <td>
          
<a href="/admin/posts/<?= $item->id;?>" class="btn btn-primary">Editer</a>
 <form style="display: inline;" action="/admin/posts/<?= $item->id;?>" method="POST" onsubmit="return confirm('êtes vous sûr ?')"> 
     <input type="hidden" name="_method" value="DELETE">
          <button class="btn btn-danger">Supprimer</button>
          <?php echo $this->csrf_input();?>  
    

  </form>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table> 
<?php echo $this->paginate($items, 'blog.admin.index'); ?>











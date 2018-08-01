<?php $this->insert('partials/header') ?>

<h1>Bienvenue sur le blog</h1>

<div class="row">

 
    <?php foreach ($posts as $post) : ?>
<div class="column"> 
   
    <div class="card-header">
            
 <h3><a href="<?= $router->generateUri('blog.show', ['slug' => $post->slug, 'id' => $post->id]); ?>"><?= $post->name;?></a>  </h3>
           
    </div>
    <div class="card-block">
              <p class="card-text">
                <?= $this->excerpt($post->content); ?>
              </p>
              <p class="text-muted"><?=$this->ago($post->created_at)?></p>
            </div>
            <div class="card-footer">
              <a href="<?= $router->generateUri('blog.show', ['slug' => $post->slug, 'id' => $post->id]); ?>" class="btn btn-primary">
                Voir l'article
              </a>
    </div>
</div>
    <?php endforeach; ?>

 </div>

<?php echo $this->paginate($posts, 'blog.index'); ?> 

<?php $this->insert('partials/footer') ?>



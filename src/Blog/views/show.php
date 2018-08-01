<?php $this->insert('partials/header') ?>

<ul>
   
    <li <?=$this->uri('/news', 'class="selected"')?>><a href="/news">News</a></li>
    
</ul>


 <h1><?= $post->name ;?></h1>
<?= $post->created_at;?>
<p class="text-muted"><?=$this->ago($post->created_at)?></p>
<?php if(isset($post->image)): ?>
<img src="<?= $post->getThumb();?>" alt="<?= $post->getImageUrl() ;?>" width="20%">

<?php endif; ?>

<?= $post->content ;?>

<?php $this->insert('partials/footer') ?>

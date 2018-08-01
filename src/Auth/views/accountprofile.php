<?php $this->layout('template', ['title' => 'Admin']) ?>

<?php if ($user !== null) : ?>
<div>

    <?php var_dump($user->username);?>
    <?php var_dump($user->email);?>
</div>
<?php endif; ?> 

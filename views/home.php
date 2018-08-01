<!DOCTYPE html>
<html>
<head>
    <title><?= isset($title) ? $title : 'Mon site'; ?></title>
    <link rel="stylesheet" href="/css/main.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css"
          integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <style>
        body {
            padding-top: 5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
    <a class="navbar-brand" href="/news">Newshhhh</a>
    <ul class="nav navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">About</a>
        </li>
    </ul>
</nav>

<div class="container">


<h1>HOME </h1>



<ul>
    <li><a href="<?= $router->generateUri('blog.index', []); ?>">Blog</a></li>
    <li>autre</li>
    <li>another nnnnn</li>
    <li>alter</li>
    <li>ego </li>
    <li>sum</li>
</ul>

<?php $this->insert('partials/footer') ?>


</body>
</html>

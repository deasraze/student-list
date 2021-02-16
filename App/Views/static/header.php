<?php

use App\Components\Navbar;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <title><?= $title ?></title>
</head>
<body>
<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="/" class="navbar-brand">Student List</a>
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navContent"
                    aria-controls="navContent" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <?php
                $menuItems = [
                    ['label' => 'Home', 'url' => '/'],
                    ['label' => 'Add yourself', 'url' => '/register'],
                    ['label' => 'Edit information', 'url' => '/edit']
                ];
                echo (new Navbar($menuItems))->getNav();
                ?>
                <form action="" class="d-flex needs-validation" novalidate>
                    <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" required>
                    <button class="btn btn-outline-light px-3" type="submit">Go!</button>
                </form>
            </div>
        </div>
    </nav>
</header>

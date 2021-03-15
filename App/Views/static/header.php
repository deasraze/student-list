<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="icon" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<header class="fixed-top">
    <?php
    $menuLabel = ($auth) ? 'Edit information' : 'Add yourself';
    $menuItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => $menuLabel, 'url' => '/form'],
    ];
    echo $navbar->getNav('Student List', $menuItems);
    ?>
</header>

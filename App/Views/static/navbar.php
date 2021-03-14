<?php

use App\Components\Utils\StringUtil;

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="/" class="navbar-brand"><?= StringUtil::html($brandLabel) ?></a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navContent"
                aria-controls="navContent" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                foreach ($menuItems as $item): ?>
                <li class="nav-item">
                    <a href="<?= StringUtil::html($item['url']) ?>" class="nav-link
                    <?= StringUtil::html($navbar->checkActiveItem($item['url'])) ?>">
                        <?= StringUtil::html($item['label'])?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <form action="/search" method="get" class="d-flex needs-validation" novalidate>
                <input class="form-control me-3" type="search" name="search"
                       placeholder="Search" aria-label="Search" required>
                <button class="btn btn-outline-light px-3" type="submit">Go!</button>
            </form>
        </div>
    </div>
</nav>

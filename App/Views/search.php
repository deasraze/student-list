<?php

use App\Components\Utils\StringUtil;

require_once ROOT . '/../App/Views/static/header.php'
?>
<section class="hero text-center">
    <div class="container">
        <div class="hero__inner row justify-content-center position-relative">
            <div class="col-lg-8">
                <h1 class="hero__title mb-3">Website for registration of abiturients</h1>
                <h2 class="hero__description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad cupiditate
                    deleniti doloremque excepturi odit saepe sapiente, sint totam velit voluptatem. Accusamus, animi,
                    distinctio! Delectus neque perferendis rem, unde voluptas voluptates!</h2>
            </div>
        </div>
    </div>
</section>

<section class="students my-5">
    <div class="container">
        <?php if (count($students) !== 0): ?>
        <h3 class="students__title">Search results for the query: <?= StringUtil::html($searchQuery) ?></h3>
        <?php require_once ROOT . '/../App/Views/static/table.php' ?>
        <?php else: ?>
        <h3 class="students__title text-center">Unfortunately, nothing was found for your search</h3>
        <?php endif; ?>
    </div>
</section>
<?php require_once ROOT . '/../App/Views/static/pagination.php'?>
<?php require_once ROOT . '/../App/Views/static/footer.php' ?>
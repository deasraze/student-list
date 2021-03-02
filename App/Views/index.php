<?php

use App\Components\Utils\StringUtil;

require_once ROOT . '/../App/Views/static/header.php'
?>
<?php if ($notify): ?>
<div class="notification">
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Well done!</h4>
            Your data has been <?= StringUtil::html($notify) ?> successfully
            <button type="button" id="notification-close" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
<?php endif; ?>
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

<section class="students text-center mt-5 mb-4">
    <div class="container">
        <h3 class="students__title">List of abiturients</h3>
        <?php require_once ROOT . '/../App/Views/static/table.php' ?>
    </div>
</section>

<?= $pagination->run() ?>
<?php require_once ROOT . '/../App/Views/static/footer.php' ?>
<?php

use App\Components\Utils\NotificationUtil;

require_once ROOT . '/../App/Views/static/header.php'
?>
<?php if ($notify): ?>
<div class="notification">
    <div class="container">
        <?= ($notify === 'danger')
            ? NotificationUtil::getNotification(
                'danger',
                'Oops..',
                "Your search query does not contain a search phrase"
            )
            : NotificationUtil::getNotification(
                'success',
                'Well done!',
                "Your data has been $notify successfully"
            );
        ?>
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

<section class="students text-center my-5">
    <div class="container">
        <h3 class="students__title">List of abiturients</h3>
        <?php require_once ROOT . '/../App/Views/static/table.php' ?>
    </div>
</section>

<?= $pagination->run() ?>
<?php require_once ROOT . '/../App/Views/static/footer.php' ?>
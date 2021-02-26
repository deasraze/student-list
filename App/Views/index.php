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
        <table class="students__table table table-bordered my-4">
            <thead class="table-dark align-middle">
            <tr>
                <td>
                    <a href="<?= StringUtil::html($link->getSortLink('id')) ?>"
                       class="thead__link">#</a>
                </td>
                <td>
                    <a href="<?= StringUtil::html($link->getSortLink('name')) ?>"
                       class="thead__link">First name</a>
                </td>
                <td>
                    <a href="<?= StringUtil::html($link->getSortLink('surname')) ?>"
                       class="thead__link">Last name</a>
                </td>
                <td>
                    <a href="<?= StringUtil::html($link->getSortLink('sgroup')) ?>"
                       class="thead__link">Group number</a>
                </td>
                <td>
                    <a href="<?= StringUtil::html($link->getSortLink('score')) ?>"
                       class="thead__link">Score</a>
                </td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= StringUtil::html($student->id) ?></td>
                <td><?= StringUtil::html($student->name) ?></td>
                <td><?= StringUtil::html($student->surname) ?></td>
                <td><?= StringUtil::html($student->sgroup) ?></td>
                <td><?= StringUtil::html($student->score) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<div class="pagination mb-5">
    <div class="container">
        <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a href="" class="page-link" aria-label="First" aria-disabled="true">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item active"><a href="" class="page-link">1</a></li>
                <li class="page-item"><a href="" class="page-link">2</a></li>
                <li class="page-item"><a href="" class="page-link">3</a></li>
                <li class="page-item"><a href="" class="page-link">4</a></li>
                <li class="page-item"><a href="" class="page-link">5</a></li>
                <li class="page-item">
                    <a href="" class="page-link" aria-label="Last">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php require_once ROOT . '/../App/Views/static/footer.php' ?>
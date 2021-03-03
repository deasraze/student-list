<?php

use App\Components\Utils\StringUtil;

?>
<table class="students__table table table-bordered mt-4 text-center">
    <thead class="table-dark align-middle">
    <tr>
        <td>
            <a href="<?= StringUtil::html($sorting->getSortLink('id')) ?>"
               class="thead__link"># <?= $sorting->getSortIcon('id')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($sorting->getSortLink('name')) ?>"
               class="thead__link">First name <?= $sorting->getSortIcon('name')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($sorting->getSortLink('surname')) ?>"
               class="thead__link">Last name <?= $sorting->getSortIcon('surname')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($sorting->getSortLink('sgroup')) ?>"
               class="thead__link">Group number <?= $sorting->getSortIcon('sgroup')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($sorting->getSortLink('score')) ?>"
               class="thead__link">Score <?= $sorting->getSortIcon('score')?>
            </a>
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


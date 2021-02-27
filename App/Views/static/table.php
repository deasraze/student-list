<?php

use App\Components\Utils\SortIconUtil;
use App\Components\Utils\StringUtil;

?>
<table class="students__table table table-bordered my-4 text-center">
    <thead class="table-dark align-middle">
    <tr>
        <td>
            <a href="<?= StringUtil::html($link->getSortLink('id')) ?>"
               class="thead__link">#
                <?= SortIconUtil::getSortIcon($sorting, 'id')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($link->getSortLink('name')) ?>"
               class="thead__link">First name
                <?= SortIconUtil::getSortIcon($sorting, 'name')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($link->getSortLink('surname')) ?>"
               class="thead__link">Last name
                <?= SortIconUtil::getSortIcon($sorting, 'surname')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($link->getSortLink('sgroup')) ?>"
               class="thead__link">Group number
                <?= SortIconUtil::getSortIcon($sorting, 'sgroup')?>
            </a>
        </td>
        <td>
            <a href="<?= StringUtil::html($link->getSortLink('score')) ?>"
               class="thead__link">Score
                <?= SortIconUtil::getSortIcon($sorting, 'score')?>
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


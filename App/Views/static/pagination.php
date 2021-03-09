<?php

use App\Components\Utils\StringUtil;

if ($pagination->run()):
    $firstPageAccess = $pagination->getAccessForArrowItem(1);
    $lastPageAccess = $pagination->getAccessForArrowItem($pagination->getTotalLinks());
?>
<div class="pagination mb-5">
    <div class="container">
        <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $firstPageAccess['access'] ?>">
                    <a href="<?= StringUtil::html($pagination->getPageLink(1)) ?>"
                       class="page-link" aria-label="First page" <?= $firstPageAccess['aria'] ?>>
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($page = $pagination->getStart(); $page <= $pagination->getEnd(); $page++): ?>
                    <li class="page-item <?= ($pagination->checkActive($page)) ? 'active' : '' ?>">
                        <a href="<?= StringUtil::html($pagination->getPageLink($page)) ?>"
                           class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $lastPageAccess['access'] ?>">
                    <a href="<?= StringUtil::html($pagination->getPageLink($pagination->getTotalLinks())) ?>"
                       class="page-link" aria-label="Last page" <?= $lastPageAccess['aria'] ?>>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php endif; ?>

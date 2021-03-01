<?php

namespace App\Components;

use App\Components\Helpers\LinkHelper;

class Pagination
{
    /**
     * Current page
     * @var int
     */
    private int $currentPage;

    /**
     * Total number of entries
     * @var int
     */
    private int $totalRecords;

    /**
     * Number of entries per page
     * @var int
     */
    private int $recordsPerPage;

    /**
     * LinkHelper
     * @var LinkHelper
     */
    private LinkHelper $linkHelper;

    /**
     * Number of links per page
     * @var int
     */
    private int $linksPerPage = 5;

    /**
     * Total number of links
     * @var int
     */
    private int $totalLinks;

    /**
     * Pagination constructor.
     * @param int $currentPage
     * @param int $totalRecords
     * @param int $recordsPerPage
     * @param LinkHelper $linkHelper
     * @throws \Exception
     */
    public function __construct(int $currentPage, int $totalRecords, int $recordsPerPage, LinkHelper $linkHelper)
    {
        $this->totalRecords = $totalRecords;
        $this->recordsPerPage = $recordsPerPage;
        $this->linkHelper = $linkHelper;
        $this->totalLinks = $this->countTotalLinks();
        $this->setCurrentPage($currentPage);
    }

    /**
     * @param int $linksPerPage
     */
    public function setLinksPerPage(int $linksPerPage): void
    {
        if ($linksPerPage < 3) {
            throw new \ValueError('The number of links on the page cannot be less than three');
        }

        $this->linksPerPage = $linksPerPage;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->recordsPerPage * ($this->currentPage - 1);
    }

    /**
     * @return string
     */
    public function run(): string
    {
        [$start, $end] = $this->calculatePagination();
        $items = '';

        for ($page = $start; $page <= $end; $page++) {
            $items .= $this->getPageItem($page);
        }

        return $this->getHtml($items);
    }

    /**
     * @return int[]
     */
    private function calculatePagination(): array
    {
        $startOffset = (int)ceil($this->currentPage - ($this->linksPerPage / 2));
        $start = ($startOffset > 1) ? $startOffset : 1;
        $end = $this->totalLinks;

        if ($start + $this->linksPerPage <= $this->totalLinks) {
            $end = ($start > 1) ? $start + $this->linksPerPage - 1 : $this->linksPerPage;
        } else {
            $start = ($this->totalLinks - $this->linksPerPage > 0) ? $this->totalLinks - $this->linksPerPage + 1 : 1;
        }

        return [$start, $end];
    }

    /**
     * @param string $items
     * @return string
     */
    private function getHtml(string $items): string
    {
        $pagination = '<ul class="pagination justify-content-center">';
        $pagination .= $this->getArrowItem(1) . $items . $this->getArrowItem($this->totalLinks) . '</ul>';

        return $pagination ;
    }

    /**
     * @param int $page
     * @return string
     */
    private function getPageItem(int $page): string
    {
        $link = $this->getPageLink($page);
        $active = ($this->checkActive($page)) ? 'active' : '';

        return "<li class='page-item $active'><a href='$link' class='page-link'>$page</a></li>";
    }

    /**
     * @param int $arrowToPage
     * @return string
     */
    private function getArrowItem(int $arrowToPage): string
    {
        if ($arrowToPage < 1) {
            throw new \ValueError('The page cannot be less than or equal to zero');
        }

        [$access, $aria] = $this->getAccessForItem();
        $symbol = ($arrowToPage === 1) ? '&laquo;' : '&raquo;';

        return "<li class='page-item $access'>
                    <a href='{$this->getPageLink($arrowToPage)}' class='page-link' aria-label='First' $aria>
                        <span aria-hidden='true'>$symbol</span>
                    </a>
                </li>";
    }

    /**
     * @return array
     */
    public function getAccessForItem(): array
    {
        $access = ($this->currentPage === 1) ? 'disabled' : '';
        $aria = ($access === 'disabled') ? 'aria-disabled="true"' : '';

        return [$access, $aria];
    }

    /**
     * @param int $page
     * @return string
     */
    private function getPageLink(int $page): string
    {
        return ($this->currentPage === $page) ? '#' : $this->linkHelper->getPageLink($page);
    }

    /**
     * @param int $page
     * @return bool
     */
    private function checkActive(int $page): bool
    {
        return ($this->currentPage === $page);
    }

    /**
     * @param int $currentPage
     * @throws \Exception
     */
    private function setCurrentPage(int $currentPage): void
    {
        if ($currentPage < 1) {
            throw new \Exception('The page cannot be less than or equal to zero');
        }
        if ($currentPage > $this->totalLinks) {
            throw new \Exception('Page not found');
        }

        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    private function countTotalLinks(): int
    {
        return ceil($this->totalRecords / $this->recordsPerPage);
    }
}

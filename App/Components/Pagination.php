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
    private int $linksPerPage = 9;

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
     * Setting a value for the number of output links for pagination
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
     * Getting a value for the number of output links for pagination
     * @return int
     */
    public function getLinksPerPage(): int
    {
        return $this->linksPerPage;
    }

    /**
     * Getting the offset for the output records
     * @return int
     */
    public function getOffset(): int
    {
        return $this->recordsPerPage * ($this->currentPage - 1);
    }

    /**
     * Run pagination
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
     * Calculating the first and last reference for pagination
     * @return int[]
     */
    private function calculatePagination(): array
    {

        /** Calculate the shift on the left so that the current page is in the middle */
        $startOffset = (int)ceil($this->currentPage - ($this->linksPerPage / 2));
        $start = ($startOffset > 1) ? $startOffset : 1;
        $end = $this->totalLinks;

        /** Check that the first link + the number of links to the page is less
         *  than the total number of links to calculate the last link
         */
        if ($start + $this->linksPerPage <= $this->totalLinks) {
            $end = ($start > 1) ? $start + $this->linksPerPage - 1 : $this->linksPerPage;
        } else {
            /** If the first link + the number of links to the page is greater
             * than the total number of links, then we calculate which link to start with
             */
            $start = ($this->totalLinks > $this->linksPerPage) ? $this->totalLinks - $this->linksPerPage + 1 : 1;
        }

        return [$start, $end];
    }

    /**
     * Getting a html for pagination
     * @param string $items
     * @return string
     */
    private function getHtml(string $items): string
    {
        $pagination = '<ul class="pagination justify-content-center">';
        $pagination .= $this->getArrowItem(1, $this->getAccessForArrowItem(1));
        $pagination .= $items . $this->getArrowItem($this->totalLinks, $this->getAccessForArrowItem($this->totalLinks));
        $pagination .= '</ul>';

        return $pagination;
    }

    /**
     * Getting a pagination item
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
     * Getting a arrow item for pagination
     * @param int $arrowToPage
     * @param array $accessForArrow
     * @return string
     */
    private function getArrowItem(int $arrowToPage, array $accessForArrow): string
    {
        [$access, $aria] = $accessForArrow;
        $symbol = ($arrowToPage === 1) ? '&laquo;' : '&raquo;';

        return "<li class='page-item $access'>
                    <a href='{$this->getPageLink($arrowToPage)}' class='page-link' aria-label='First' $aria>
                        <span aria-hidden='true'>$symbol</span>
                    </a>
                </li>";
    }

    /**
     * Getting access to the arrow item
     * @param int $page
     * @return array
     */
    private function getAccessForArrowItem(int $page): array
    {
        $access = ($this->currentPage === $page) ? 'disabled' : '';
        $aria = ($access === 'disabled') ? 'aria-disabled="true"' : '';

        return [$access, $aria];
    }

    /**
     * Getting link for page
     * @param int $page
     * @return string
     */
    private function getPageLink(int $page): string
    {
        return ($this->currentPage === $page) ? '#' : $this->linkHelper->getPageLink($page);
    }

    /**
     * Checking page activity
     * @param int $page
     * @return bool
     */
    private function checkActive(int $page): bool
    {
        return ($this->currentPage === $page);
    }

    /**
     * Setting the current page
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
     * Count total links
     * @return int
     */
    private function countTotalLinks(): int
    {
        return ceil($this->totalRecords / $this->recordsPerPage);
    }
}

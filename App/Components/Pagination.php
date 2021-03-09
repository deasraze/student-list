<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components;

use App\Components\Exceptions\NotFoundException;
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
    private int $linksPerPage = 7;

    /**
     * Total number of links
     * @var int
     */
    private int $totalLinks;

    /**
     * Pagination start
     * @var int
     */
    private int $start;

    /**
     * Pagination end
     * @var int
     */
    private int $end;

    /**
     * Pagination constructor.
     * @param int $currentPage
     * @param int $totalRecords
     * @param int $recordsPerPage
     * @param LinkHelper $linkHelper
     * @throws NotFoundException|\ValueError
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
     * @return bool
     */
    public function run(): bool
    {
        if ($this->totalLinks <= 1) {
            return false;
        }

        [$this->start, $this->end] = $this->calculatePagination();

        return true;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getTotalLinks(): int
    {
        return $this->totalLinks;
    }

    /**
     * Getting access to the arrow item
     * @param int $page
     * @return array
     */
    public function getAccessForArrowItem(int $page): array
    {
        $access = ($this->checkActive($page)) ? 'disabled' : '';
        $aria = ($this->checkActive($page)) ? 'aria-disabled="true"' : '';

        return ['access' => $access, 'aria' => $aria];
    }

    /**
     * Getting link for page
     * @param int $page
     * @return string
     */
    public function getPageLink(int $page): string
    {
        return ($this->currentPage === $page) ? '#' : $this->linkHelper->getPageLink($page);
    }

    /**
     * Checking page activity
     * @param int $page
     * @return bool
     */
    public function checkActive(int $page): bool
    {
        return ($this->currentPage === $page);
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
     * Setting the current page
     * @param int $currentPage
     * @throws NotFoundException|\ValueError
     */
    private function setCurrentPage(int $currentPage): void
    {
        if ($currentPage < 1) {
            throw new \ValueError('The page cannot be less than or equal to zero');
        }
        if ($currentPage > $this->totalLinks && $this->totalLinks !== 0) {
            throw new NotFoundException("Page $currentPage for pagination not found");
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

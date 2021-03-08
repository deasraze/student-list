<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Helpers;

use App\Components\Interfaces\RequestInterface;

class SortingHelper
{
    /**
     * @var LinkHelper
     */
    private LinkHelper $linkHelper;

    /**
     * Key for sorting
     * @var string
     */
    private string $sortKey;

    /**
     * Sort type
     * @var string
     */
    private string $sortType;

    /**
     * SortingHelper constructor.
     * @param RequestInterface $request
     * @param LinkHelper $linkHelper
     * @param string $defaultSortKey
     * @param string $defaultSortType
     */
    public function __construct(
        RequestInterface $request,
        LinkHelper $linkHelper,
        string $defaultSortKey,
        string $defaultSortType
    ) {
        $this->linkHelper = $linkHelper;
        $this->sortKey = $request->getRequestBody('key', $defaultSortKey);
        $this->sortType = $request->getRequestBody('sort', $defaultSortType);
    }

    /**
     * @param string $currentKey
     * @return string
     */
    public function getSortLink(string $currentKey): string
    {
        return $this->linkHelper->getSortLink($currentKey);
    }

    /**
     * Getting sort icon
     * @param string $currentKey
     * @return string
     */
    public function getSortIcon(string $currentKey): string
    {
        $asc = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" 
                        class="thead-sort-icon bi bi-caret-up-fill" viewBox="0 0 16 16">
                <path d="M7.247 4.86l-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 
                        0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                </svg>';
        $desc = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" 
                        class="thead-sort-icon bi bi-caret-down-fill" viewBox="0 0 16 16">
                 <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 
                        1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                 </svg>';
        $default = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" 
                           class="thead-sort-icon" viewBox="0 0 401.998 401.998" fill="currentColor">
                    <path d="M73.092,164.452h255.813c4.949,0,9.233-1.807,12.848-5.424c3.613-3.616,5.427-7.898,5.427-12.847
                           c0-4.949-1.813-9.229-5.427-12.85L213.846,5.424C210.232,
                           1.812,205.951,0,200.999,0s-9.233,1.812-12.85,5.424L60.242,133.331
                           c-3.617,3.617-5.424,7.901-5.424,12.85c0,4.948,1.807,9.231,
                           5.424,12.847C63.863,162.645,68.144,164.452,73.092,164.452z"/>
                    <path d="M328.905,237.549H73.092c-4.952,0-9.233,1.808-12.85,5.421c-3.617,3.617-5.424,7.898-5.424,12.847
                           c0,4.949,1.807,9.233,5.424,12.848L188.149,396.57c3.621,3.617,7.902,5.428,
                           12.85,5.428s9.233-1.811,12.847-5.428l127.907-127.906
                           c3.613-3.614,5.427-7.898,5.427-12.848c0-4.948-1.813-9.229-5.427-12.847C338.139,
                           239.353,333.854,237.549,328.905,237.549z"/>
                    </svg>';

        if ($this->sortKey !== $currentKey) {
            return $default;
        }

        return ($this->sortType === 'asc' && $this->sortKey === $currentKey) ? $asc : $desc;
    }

    /**
     * @return string
     */
    public function getSortKey(): string
    {
        return $this->sortKey;
    }

    /**
     * @return string
     */
    public function getSortType(): string
    {
        return $this->sortType;
    }
}

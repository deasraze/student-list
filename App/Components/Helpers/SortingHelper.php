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
        $dir = ROOT . '/../App/Views/static/svg/';

        if ($this->sortKey !== $currentKey) {
            return file_get_contents($dir . 'default.html');
        }

        return ($this->sortType === 'asc')
            ? file_get_contents($dir . 'asc.html')
            : file_get_contents($dir . 'desc.html');
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

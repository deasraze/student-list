<?php

namespace App\Components\Helpers;

use App\Components\Interfaces\RequestInterface;

class LinkHelper
{
    /**
     * Current uri
     * @var string
     */
    private string $urlPath;

    /**
     * Key for sorting
     * @var string|null
     */
    private ?string $sortKey;

    /**
     * Sort type
     * @var string|null
     */
    private ?string $sortType;

    /**
     * Search query string
     * @var string|null
     */
    private ?string $searchQuery;

    /**
     * Current page
     * @var int|null
     */
    private ?int $page;

    /**
     * LinkHelper constructor.
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->urlPath = $request->getUrlPath();
        $this->sortKey = $request->getRequestBody('key');
        $this->sortType = $request->getRequestBody('sort');
        $this->searchQuery = $request->getRequestBody('search');
        $this->page = $request->getRequestBody('page');
    }

    /**
     * Getting a sort link
     * @param string $key
     * @return string
     */
    public function getSortLink(string $key): string
    {
        $query = $this->getQueryArray();
        $query['key'] = $key;
        $query['sort'] = ($this->sortType === 'asc' && $this->sortKey === $key) ? 'desc' : 'asc';

        return $this->generateLink(http_build_query($query));
    }

    /**
     * Getting a page link
     * @param int $page
     * @return string
     */
    public function getPageLink(int $page): string
    {
        $query = $this->getQueryArray();
        $query['page'] = $page;

        return $this->generateLink(http_build_query($query));
    }

    /**
     * Getting a notify link
     * @param string $notify
     * @param string|null $token
     * @return string
     */
    public function getNotifyLink(string $notify, string $token = null): string
    {
        return '/?' . http_build_query([
            'notification' => $notify,
            'for' => $token
        ]);
    }

    /**
     * Generating a link with the passed query string
     * @param string $query
     * @return string
     */
    private function generateLink(string $query): string
    {
        return "{$this->urlPath}?$query";
    }

    /**
     * Getting an array of query
     * @return array
     */
    private function getQueryArray(): array
    {
        return [
            'search' => $this->searchQuery,
            'key'    => $this->sortKey,
            'sort'   => $this->sortType,
            'page'   => $this->page
        ];
    }
}

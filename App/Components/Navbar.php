<?php

namespace App\Components;

use App\Components\Interfaces\RequestInterface;

class Navbar
{
    /**
     * The first part of the url path
     * @var string
     */
    private string $url;

    /**
     * Navbar constructor.
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->url = explode('/', $request->getUrlPath())[1];
    }

    /**
     * Get the menu for the site
     * @param array example: [['label' => 'Home', 'url' => '/']], ...
     * @return string html navbar menu
     * @throws \ValueError
     */
    public function getNav(array $menuItems): string
    {
        $items = '';
        foreach ($menuItems as $item) {
            if (!array_key_exists('label', $item) || !array_key_exists('url', $item)) {
                throw new \ValueError('The passed array does not contain the label or url key');
            }

            $items .= $this->getItem($item);
        }

        return $this->getHtml($items);
    }

    /**
     * Getting html for menu item
     * @param array $item
     * @return string
     */
    private function getItem(array $item): string
    {
        $active = $this->checkActiveItem($item['url']);
        return "<li class='nav-item'><a href='{$item['url']}' class='nav-link $active'>{$item['label']}</a></li>";
    }

    /**
     * Getting html for menu
     * @param string $items
     * @return string
     */
    private function getHtml(string $items): string
    {
        return sprintf('<ul class="navbar-nav me-auto mb-2 mb-lg-0">%s</ul>', $items);
    }

    /**
     * Checking whether the current menu is currently active
     * @param string $url
     * @return string class
     */
    private function checkActiveItem(string $url): string
    {
        return ($this->url === trim($url, '/')) ? 'active' : '';
    }
}

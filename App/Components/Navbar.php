<?php

namespace App\Components;

use App\Components\Interfaces\RequestInterface;

class Navbar
{
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
     * @param array example: ['label' => 'Home', 'url' => '/'], ...
     * @return string html navbar menu
     */
    public function getNav(array $menuItems): string
    {
        $menu= '';
        foreach ($menuItems as $item) {
            $active = $this->checkActiveItem($item['url']);
            $menu .= "<li class='nav-item'><a href='{$item['url']}' class='nav-link $active'>{$item['label']}</a></li>";
        }
        return "<ul class='navbar-nav me-auto mb-2 mb-lg-0'>$menu</ul>";
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

<?php

namespace App\Components;

class Navbar
{
    private string $url;

    private array $menuItem;

    /**
     * Navbar constructor.
     * Example: ['label' => 'Home', 'url' => '/'], ...
     * @param array of items that should be in the menu
     */
    public function __construct(array $menuItem)
    {
        $this->menuItem = $menuItem;
        $this->url = $this->parseUrl();
    }

    /**
     * Get the menu for the site
     * @return string html navbar menu
     */
    public function getNav(): string
    {
        $menu= '';
        foreach ($this->menuItem as $item) {
            $active = self::checkActiveItem($item['url']);
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

    /**
     * @return string current url_path
     */
    private function parseUrl(): string
    {
        return parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);

    }
}
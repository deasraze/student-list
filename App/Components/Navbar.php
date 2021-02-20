<?php

namespace App\Components;

class Navbar
{
    private string $url;

    private array $menuItems;
    
    /**
     * Navbar constructor.
     * Set a list of items that should be in the menu
     * @param array example: ['label' => 'Home', 'url' => '/'], ...
     */
    public function __construct(array $menuItems)
    {
        $this->menuItems = $menuItems;
        $this->url = $this->parseUrl();
    }
    
    /**
     * Get the menu for the site
     * @return string html navbar menu
     */
    public function getNav(): string
    {
        $menu= '';
        foreach ($this->menuItems as $item) {
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
     * Parsing the current url_path
     * @return string current url_path
     */
    private function parseUrl(): string
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return explode('/', $url)[1];
    }
}

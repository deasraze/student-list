<?php


namespace App\Components;


class Navbar
{
    private static string $url;
    private static array $menuItem;


    public function __construct()
    {
    }

    /**
     * Get the menu for the site
     * @return string html navbar menu
     */
    public static function getNav(): string
    {
        $menuItem = '';
        foreach (self::$menuItem as $value) {
            $active = self::checkActiveItem($value['url']);
            $menuItem .= "<li class='nav-item'><a href='{$value['url']}' class='nav-link $active'>{$value['label']}</a></li>";
        }
        return "<ul class='navbar-nav me-auto mb-2 mb-lg-0'>$menuItem</ul>";
    }

    /**
     * Example: ['label' => 'Home', 'url' => '/'], ...
     * @param array of items that should be in the menu
     */
    public static function setNavBar(array $menuItem): void
    {
        self::$url = self::parseUrl();
        self::$menuItem = $menuItem;
    }

    /**
     * Checking whether the current menu is currently active
     * @param string $url
     * @return string class
     */
    private static function checkActiveItem(string $url)
    {
        return (self::$url === trim($url, '/')) ? 'active' : '';
    }

    /**
     * @return string current url_path
     */
    private static function parseUrl(): string
    {
        return parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);

    }
}
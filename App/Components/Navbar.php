<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components;

use App\Components\Exceptions\FileNotExistException;
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
     * @param string $brandLabel
     * @param array example: [['label' => 'Home', 'url' => '/']], ...
     * @return string html navbar menu
     * @throws FileNotExistException
     */
    public function getNav(string $brandLabel, array $menuItems): string
    {
        $menuItems = $this->filterItems($menuItems);
        $view = new View(ROOT . '/../App/Views/static/', 'php');

        return $view->render('navbar', [
            'brandLabel' => $brandLabel,
            'menuItems' => $menuItems,
            'navbar' => $this
        ]);
    }

    /**
     * Checking whether the current menu is currently active
     * @param string $url
     * @return string class
     */
    public function checkActiveItem(string $url): string
    {
        return ($this->url === trim($url, '/')) ? 'active' : '';
    }

    /**
     * Filters the menu for the necessary keys in the array and returns it if they are present
     * @param array $menuItems
     * @return array
     */
    private function filterItems(array $menuItems): array
    {
        foreach ($menuItems as $item) {
            if (!array_key_exists('label', $item) || !array_key_exists('url', $item)) {
                throw new \ValueError('The passed array does not contain the label or url key');
            }
        }

        return $menuItems;
    }
}

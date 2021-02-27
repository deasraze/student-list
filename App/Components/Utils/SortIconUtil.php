<?php

namespace App\Components\Utils;

class SortIconUtil
{
    /**
     * Getting sort icon
     * @param array example: ['key' => 'id', 'sort' => 'asc']
     * @param string $key
     * @return string
     */
    public static function getSortIcon(array $sorting, string $key): string
    {
        if (array_key_exists('sort', $sorting) && array_key_exists('key', $sorting)) {
            $asc = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                        class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                    <path d="M7.247 4.86l-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 
                        0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                    </svg>';

            $desc = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                        class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                    <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 
                        1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                    </svg>';

            return ($sorting['sort'] === 'asc' && $sorting['key'] === $key) ? $asc : $desc;
        }

        throw new \ValueError('There is no indexes key or sort in the passed array');
    }
}

<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components;

use App\Components\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    /**
     * Request body
     * @var array
     */
    private array $requestBody;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->requestBody = array_merge(
            $this->parsingQueryParams(),
            $this->parsingPostRequest()
        );
    }

    /**
     * Get all parameters from the request body
     * @param string|null $key
     * @param null $default
     * @return array|string|null
     */
    public function getRequestBody(string $key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->requestBody;
        }

        return $this->requestBody[$key] ?? $default;
    }

    /**
     * Checks whether the request method is a post
     * @return bool
     */
    public function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    /**
     * Get current URI
     * @return string
     */
    public function getRequestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Getting current URL PATH
     * @return string
     */
    public function getUrlPath(): string
    {
        return (parse_url($this->getRequestUri(), PHP_URL_PATH)) ?: '';
    }

    /**
     * Parsing GET parameters in a request
     * @return array
     */
    private function parsingQueryParams(): array
    {
        return (!empty($_SERVER['QUERY_STRING'])) ? $_GET : [];
    }

    /**
     * Parsing POST parameters in a request
     * @return array
     */
    private function parsingPostRequest(): array
    {
        return (!empty($_POST)) ? $_POST : [];
    }
}

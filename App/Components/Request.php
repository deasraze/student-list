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
     * Request uri
     * @var string
     */
    private string $uri;

    /**
     * Request url path
     * @var string
     */
    private string $urlPath;

    /**
     * Request method
     * @var string
     */
    private string $method;

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
        $this->uri = $this->getCurrentUri();
        $this->urlPath = $this->getCurrentUrlPath();
        $this->method = $this->getCurrentMethod();
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
        return ($this->method === 'POST');
    }

    /**
     * Get current URI
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Getting current URL PATH
     */
    public function getUrlPath(): string
    {
        return $this->urlPath;
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

    /**
     * Getting the current request uri
     * @return string
     */
    private function getCurrentUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Getting the current request url path
     * @return string
     */
    private function getCurrentUrlPath(): string
    {
        return (parse_url($this->uri, PHP_URL_PATH)) ?: '';
    }

    /**
     * Getting the current request method
     * @return string
     */
    private function getCurrentMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

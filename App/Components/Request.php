<?php

namespace App\Components;

use App\Components\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private array $queryParams;

    private array $requestParams;

    public function __construct()
    {
    }

    /**
     * Save all the parameters that were passed in the request
     * @param array $splitRealPath
     */
    public function setRequestParams(array $splitRealPath): void
    {
        $this->queryParams = $this->parsingQueryParams();
        $this->requestParams = $this->parsingRequestParams($splitRealPath);
    }

    /**
     * Getting only the parameters that were specified in the routes
     * @param string|null $key
     * @return array|false|string
     */
    public function getRequestParams(string $key = null)
    {
        if (is_null($key)) {
            return $this->requestParams;
        }

        return $this->requestParams[$key] ?? false;
    }

    /**
     * Getting GET parameters in a request
     * @param string|null $key
     * @return array|string
     */
    public function getQueryParams(string $key = null)
    {
        if (is_null($key)) {
            return $this->queryParams;
        }

        return $this->queryParams[$key] ?? false;
    }

    /**
     * Parsing GET parameters in a request
     * @return array
     */
    public function parsingQueryParams(): array
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            return $_GET;
        }

        return [];
    }

    /**
     * The parsing of the parameters specified in the routes
     * @param array $splitRealPath
     * @return array
     */
    public function parsingRequestParams(array $splitRealPath): array
    {
        $params = array_splice($splitRealPath, 2);
        if (!empty($params)) {
            $key = $value = [];
            foreach (array_chunk($params, 2) as $chunk) {
                $key[] = $chunk[0];
                $value[] = $chunk[1];
            }

            return array_combine($key, $value);
        }
        return [];
    }
}
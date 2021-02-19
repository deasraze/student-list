<?php

namespace App\Components;

use App\Components\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private array $queryParams;

    private array $requestParams;

    private array $postRequest;

    /**
     * Request constructor.
     */
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
        $this->postRequest = $this->parsingPostRequest();
    }

    /**
     * Getting only the parameters that were specified in the routes
     * @param string|null $key
     * @return array|bool
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
     * @return array|bool
     */
    public function getQueryParams(string $key = null)
    {
        if (is_null($key)) {
            return $this->queryParams;
        }

        return $this->queryParams[$key] ?? false;
    }

    /**
     * Getting POST parameters in a request
     * @param string|null $key
     * @return array|bool
     */
    public function getPostRequest(string $key = null)
    {
        if (is_null($key)) {
            return $this->postRequest;
        }

        return $this->postRequest[$key] ?? false;
    }

    /**
     * Parsing GET parameters in a request
     * @return array
     */
    public function parsingQueryParams(): array
    {
        return (!empty($_SERVER['QUERY_STRING'])) ? $_GET : [];
    }

    /**
     * Parsing POST parameters in a request
     * @return array
     */
    public function parsingPostRequest(): array
    {
        return (!empty($_POST)) ? $_POST : [];
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

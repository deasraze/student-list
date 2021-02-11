<?php

namespace App\Components;

class Request
{
    private array $queryString;
    private array $requestParams;

    public function __construct()
    {
    }

    /**
     * Save all the parameters that were passed in the request
     * @param array $splitRealPath
     */
    public function setRequestParams(array $splitRealPath)
    {
        $this->queryString = $this->parsingQueryString();
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
    public function getQueryString(string $key = null)
    {
        if (is_null($key)) {
            return $this->queryString;
        }

        return $this->queryString[$key] ?? false;
    }


    /**
     * Parsing GET parameters in a request
     * @return array
     */
    private function parsingQueryString(): array
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            return array_combine(array_keys($_GET), array_values($_GET));
        }

        return [];
    }

    /**
     * The parsing of the parameters specified in the routes
     * @param array $split
     * @return array
     */
    private function parsingRequestParams(array $split): array
    {
        $params = array_splice($split, 2);
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
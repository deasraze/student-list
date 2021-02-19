<?php

namespace App\Components;

use App\Components\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private array $requestBody;

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
        $this->requestBody = array_merge(
            $this->parsingQueryParams(),
            $this->parsingRouteParams($splitRealPath),
            $this->parsingPostRequest()
        );
    }

    /**
     * Get all parameters from the request body
     * @param string|null $key
     * @return array|bool
     */
    public function getRequestBody(string $key = null)
    {
        if (is_null($key)) {
            return $this->requestBody;
        }

        return $this->requestBody[$key] ?? false;
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
    public function parsingRouteParams(array $splitRealPath): array
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

<?php

namespace App\Components;

class Response
{
    /**
     * Response headers
     * @var array
     */
    private array $headers = [];

    /**
     * Request status code
     * @var int
     */
    private int $statusCode;

    /**
     * Response status phrase
     * @var string
     */
    private string $statusPhrase;

    /**
     * Body response
     * @var string
     */
    private string $body;

    /**
     * Default status codes and phrases for the response
     * @var array
     */
    private array $default = [
        200 => 'OK',
        400 => 'Bad Request',
        404 => 'Not Found',
        503 => 'Service Unavailable',
    ];

    /**
     * Response constructor.
     * @param array $headers
     * @param string $body
     * @param int $statusCode
     * @param string $statusPhrase
     */
    public function __construct(array $headers, string $body, int $statusCode, string $statusPhrase = '')
    {
        $this->setHeaders($headers);
        $this->body = $body;
        $this->statusCode = $this->filterStatusCode($statusCode);
        $this->statusPhrase = $this->filterStatusPhrase($statusCode, $statusPhrase);
    }

    /**
     * Getting response headers
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Getting response body
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Getting request status code
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Getting response status phrase
     * @return string
     */
    public function getStatusPhrase(): string
    {
        return $this->statusPhrase;
    }

    /**
     * Returns a clone of the Response object with the required response header
     * @param string $name
     * @param string|int $value
     * @return Response
     */
    public function withHeader(string $name, $value): Response
    {
        $clone = clone $this;
        $clone->setHeaders([$name => $value]);

        return $clone;
    }

    /**
     * Returns a clone of the Response object with the required response body
     * @param string $body
     * @return Response
     */
    public function withBody(string $body): Response
    {
        $clone = clone $this;
        $clone->body = $body;

        return $clone;
    }

    /**
     * Filters the code for the presence in the default array and returns it if it is present
     * @param int $code
     * @return int
     * @throws \InvalidArgumentException
     */
    private function filterStatusCode(int $code): int
    {
        if (!array_key_exists($code, $this->default)) {
            throw new \InvalidArgumentException('The specified status is not in the default list.');
        }

        return $code;
    }

    /**
     * Filters the status phrase.
     * Returns the phrase according to the code, if it is empty, otherwise returns it
     * @param int $code
     * @param string $statusPhrase
     * @return string
     */
    private function filterStatusPhrase(int $code, string $statusPhrase): string
    {
        return (strlen($statusPhrase) === 0) ? $this->default[$code] : $statusPhrase;
    }

    /**
     * Set headers
     * @param array $headers
     */
    private function setHeaders(array $headers): void
    {
        foreach ($headers as $name => $value) {
            if (!is_string($name)) {
                throw new \ValueError('The key for the header should only be of the string type');
            }

            $this->headers[$this->sanitizeHeaderName($name)] = $value;
        }
    }

    /**
     * Converting the name to the required format
     * @param string $name
     * @return string
     */
    private function sanitizeHeaderName(string $name): string
    {
        return ucfirst(strtolower($name));
    }
}

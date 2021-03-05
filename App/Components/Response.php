<?php

namespace App\Components;

class Response
{
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
     * @param int $statusCode
     * @param string $body
     * @param string $statusPhrase
     */
    public function __construct(string $body, int $statusCode, string $statusPhrase = '')
    {
        $this->body = $body;
        $this->statusCode = $this->filterStatusCode($statusCode);
        $this->statusPhrase = $this->filterStatusPhrase($statusCode, $statusPhrase);
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
     * Getting response body
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
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
}

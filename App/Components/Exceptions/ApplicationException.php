<?php

namespace App\Components\Exceptions;

class ApplicationException extends \Exception
{
    /**
     * Status code for response
     * @var int
     */
    protected int $statusCode;

    /**
     * Error description
     * @var string
     */
    protected string $description;

    /**
     * ApplicationException constructor.
     * @param string $message
     * @param int $statusCode
     * @param string $description
     */
    public function __construct(
        string $message,
        int $statusCode = 503,
        string $description = 'The server with the site is currently unavailable, '
        .'please try again later or contact server administrator.'
    ) {
        parent::__construct($message);

        $this->statusCode = $statusCode;
        $this->description = $description;
    }

    /**
     * Getting status code
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Getting error description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}

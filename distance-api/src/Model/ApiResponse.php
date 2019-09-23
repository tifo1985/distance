<?php

namespace App\Model;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    private const STATUS_SUCCESS = 'success';
    private const STATUS_FAILED = 'failed';

    /** @var ResponseInterface  */
    private $response;

    /** @var string */
    private $status;

    /**
     * @param ResponseInterface|null $response
     */
    public function __construct(?ResponseInterface $response)
    {
        $this->response = $response;
        $this->status = $response->getStatusCode() >= 200 && $response->getStatusCode() < 300 ? self::STATUS_SUCCESS : self::STATUS_FAILED;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return \stdClass|null
     */
    public function getResponseContents(): ?\stdClass
    {
        return json_decode($this->response->getBody()->getContents());
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->status === self::STATUS_SUCCESS;
    }
}
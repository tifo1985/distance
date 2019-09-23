<?php

namespace App\Api;

use App\Model\ApiResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class AbstractRequest
{
    /** @var ClientInterface */
    protected $client;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @required
     *
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     */
    public function init(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @param string $url
     * @param $options
     *
     * @return ApiResponse
     */
    protected function get(string $url, $options)
    {
        return $this->execute(Request::METHOD_GET, $url, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @return ApiResponse
     */
    private function execute(string $method, string $uri, array $options): ApiResponse
    {
        try{
            $response = $this->client->request($method, $uri, $options);
        }catch (RequestException $exception){
            $this->logger->error(
                $exception->getMessage(),
                [
                    'uri' => $uri,
                    'method' => $method,
                    'options' => $options
                ]
            );

            return new ApiResponse($exception->getResponse());
        }

        return new ApiResponse($response);
    }
}
<?php

namespace App\Api;

use App\Exception\CalculateDistanceException;
use Symfony\Component\HttpFoundation\Response;

final class DistanceApi extends AbstractRequest
{
    private const URI = '/api/v1';

    /**
     * @param array $args
     *
     * @return \stdClass
     */
    public function getDistatnce(array $args): \stdClass
    {
        $response = $this->get(self::URI, [
            'query' => array_filter($args)
        ]);

        return json_decode($response->getResponse()->getBody()->getContents());
    }
}
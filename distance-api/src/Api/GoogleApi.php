<?php

namespace App\Api;

use App\Exception\CalculateDistanceException;
use Symfony\Component\HttpFoundation\Response;

final class GoogleApi extends AbstractRequest
{
    private const URI = '/maps/api/distancematrix/json';

    /** @var string */
    private $apiKey;

    /**
     * @required
     *
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $origin
     * @param string $destination
     *
     * @return string
     *
     * @throws CalculateDistanceException
     */
    public function getDistatnce(string $origin, string $destination): string
    {
        $response = $this->get(self::URI, [
            'query' => array_filter([
                'key' => $this->apiKey,
                'origins' => $origin,
                'destinations' => $destination,
            ])
        ]);
        $responseContents = $response->getResponseContents();
        dump($responseContents);
        if($response->isSuccess()
            && $responseContents->status === 'OK'
            && count($responseContents->rows) > 0
            && count($responseContents->rows[0]->elements) > 0
        ){

            return $responseContents->rows[0]->elements[0]->distance->text;
        }

        if($response->isSuccess() && $responseContents->status === 'INVALID_REQUEST'){

            throw new CalculateDistanceException('destination address not valid', Response::HTTP_BAD_REQUEST);
        }

        throw new CalculateDistanceException();
    }
}
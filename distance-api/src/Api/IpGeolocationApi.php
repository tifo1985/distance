<?php

namespace App\Api;

use App\Exception\IpAddressConversionException;

final class IpGeolocationApi extends AbstractRequest
{
    private const URI = '/api/v1';

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
     * @param string $ipAddress
     *
     * @return \stdClass
     *
     * @throws IpAddressConversionException
     */
    public function getLocation(string $ipAddress)
    {
        $response = $this->get(self::URI, [
            'query' => array_filter([
                'ipAddress' => $ipAddress,
                'apiKey' => $this->apiKey
            ])
        ]);
        $responseContents = $response->getResponseContents();
        if($response->isSuccess() && isset($responseContents->location)){

            return $responseContents->location;
        }

        throw new IpAddressConversionException();
    }
}
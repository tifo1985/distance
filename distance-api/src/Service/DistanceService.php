<?php

namespace App\Service;

use App\Api\GoogleApi;
use App\Api\IpGeolocationApi;
use App\Exception\CalculateDistanceException;
use App\Exception\IpAddressConversionException;
use App\Helper\AddressHelper;
use App\Helper\LocationHelper;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DistanceService
{
    /** @var GoogleApi */
    private $googleApi;

    /** @var IpGeolocationApi */
    private $ipGeolocationApi;

    /** @var OptionsResolver */
    private $resolver;

    /**
     * @param GoogleApi $googleApi
     * @param IpGeolocationApi $ipGeolocationApi
     */
    public function __construct(GoogleApi $googleApi, IpGeolocationApi $ipGeolocationApi)
    {
        $this->googleApi = $googleApi;
        $this->ipGeolocationApi = $ipGeolocationApi;
    }

    /**
     * @param string $ipAddress
     * @param $address
     *
     * @return string
     *
     * @throw IpAddressConversionException
     * @throw CalculateDistanceException
     */
    public function calculate(string $ipAddress,array $address): string
    {
        $origin = LocationHelper::LocationToLatitudeLongitudeCoordinates($this->ipGeolocationApi->getLocation($ipAddress));
        return $this->googleApi->getDistatnce($origin, AddressHelper::toString($address));
    }
}
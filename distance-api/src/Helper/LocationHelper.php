<?php


namespace App\Helper;


final class LocationHelper
{
    /**
     * @param \stdClass $location
     *
     * @return string
     */
    public static function LocationToLatitudeLongitudeCoordinates(\stdClass $location): string
    {
        return $location->lat .',' . $location->lng;
    }
}
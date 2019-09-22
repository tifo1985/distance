<?php


namespace App\Helper;


final class AddressHelper
{
    /**
     * @param \stdClass $location
     *
     * @return string
     */
    public static function toString(array $address): string
    {
        return $address['street'] .', ' . $address['postcode'] .' ' . $address['city'] .' ' . $address['country'];
    }
}
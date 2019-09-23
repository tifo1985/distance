<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class IpAddressConversionException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Failed to convert IP Address', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
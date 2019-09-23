<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CalculateDistanceException extends \RuntimeException
{
    public function __construct($message = 'Failed to calculate distance', $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
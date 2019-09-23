<?php

namespace App\Controller;

use App\Api\IpGeolocationApi;
use App\Service\DataValidatorService;
use App\Service\DistanceService;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DistanceController
{
    /**
     * Distance between ip addresse and postal addresse.
     *
     * @Route("/api/v1", methods={"GET"})
     */
    public function calculate(Request $request, DistanceService $distanceService, DataValidatorService $validator)
    {
        $data = [
            'street' => $request->get('street'),
            'postcode' => (int) $request->get('postcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'ipAddress' => $request->get('ipAddress', '')
        ];

        $errors = $validator->validate($data);
        if (count($errors) > 0) {
            $data = [
                'code' => 'validation_error',
                'message' => 'There was a validation error',
                'errors' => $errors
            ];
            return new JsonResponse($data, 400);
        }

        return new JsonResponse([
            'distance' => $distanceService->calculate($data['ipAddress'], [
                'street' => $data['street'],
                'postcode' => $data['postcode'],
                'city' => $data['city'],
                'country' => $data['country']
            ])
        ]);
    }
}

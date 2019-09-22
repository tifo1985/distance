<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class DataValidatorService
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function validate(array $data) : array
    {
        $errors = [];
        $violationList = $this->validator->validate($data, $this->getConstraints());

        if (0 < count($violationList)) {
            foreach ($violationList as $constraintViolation){
                 $errors[] = [
                    'message' => $constraintViolation->getMessage(),
                    'property' => $constraintViolation->getPropertyPath()
                 ];
            }
        }

        return $errors;
    }

    /**
     * @return Assert\Collection
     */
    private function getConstraints(): Assert\Collection
    {

        return new Assert\Collection([
            'postal_address' => new Assert\Collection([
                'street' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'string'])
                ],
                'postcode' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'integer'])
                ],
                'city' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'string'])
                ],
                'country' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'string'])
                ]
            ]),
            'ip_address' => new Assert\Ip()
        ]);
    }
}
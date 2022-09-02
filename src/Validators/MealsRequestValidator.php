<?php

namespace App\Validators;

use App\Dto\MealsRequestDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MealsRequestValidator 
{
    private ValidatorInterface $validatorInterface;

    public function __construct(
        ValidatorInterface $validatorInterface
        )
    {
        $this->validatorInterface = $validatorInterface;
    }

    public function validateRequestParameters($parameters) : ?array
    {
        $requestDto = new MealsRequestDto();

        if (isset($parameters['lang'])) {
            $requestDto->setLang($parameters['lang']);
        }

        $errors = $this->validatorInterface->validate($requestDto);

        if (count($errors) > 0) {
            $errorList = [];
            foreach ($errors as $error) {
                $errorList[$error->getPropertyPath()] = $error->getMessage();
            }
            return $errorList;
        }
        return null;
    }
}
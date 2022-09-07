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
        
        /*if (isset($parameters['per_page'])) {
            $per_page = (int) $parameters['per_page'];
            var_dump($per_page);
            $requestDto->setPer_page($per_page);
        }*/

        if (isset($parameters['per_page'])) {
            $requestDto->setPer_page($parameters['per_page']);
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
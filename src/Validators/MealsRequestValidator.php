<?php

namespace App\Validators;

use App\Dto\MealsRequestDto;
use Symfony\Component\HttpFoundation\Response;
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

    public function validateRequest($parameters) :Response
    {
        $requestDto = new MealsRequestDto();

        if (isset($parameters['lang'])) {
            $requestDto->setLang($parameters['lang']);
        }

        $errors = $this->validatorInterface->validate($requestDto);

        if (count($errors) > 0) {
        
            $errorsString = (string) $errors;
            
            $response = new Response($errorsString);

            die('Lang parameter should not be empty');

            //return $response->setContent('Lang parameter should not be empty');
        }

        return new Response('The language is valid! Yes!');
    }
}
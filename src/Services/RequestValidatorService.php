<?php

namespace App\Services;

use App\Services\RequestDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RequestValidatorService 
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
        $requestDto = new RequestDto();

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
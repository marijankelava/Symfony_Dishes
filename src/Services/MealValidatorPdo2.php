<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;


final class MealValidatorPdo2  
{
    /**
     * @Assert\NotBlank
     */
    private string $languageIsoCode;

    private ValidatorInterface $validatorInterface;

    public function __construct(
        ValidatorInterface $validatorInterface
        //$languageIsoCode
        )
    {
        $this->validator = $validatorInterface;
        //$this->languageIsoCode = $languageIsoCode;
    }

    /*public function validatePdo($parameters) :Response
    {
        $languageIsoCode = 'hr';
        //dd($languageIsoCode);

        $validatorPdo = new MealValidatorPdo2();

        $errors = $this->validatorInterface->validate($validatorPdo);

        if (count($errors) > 0) {
        
            $errorsString = (string) $errors;
            //echo $errorsString;

            return new Response($errorsString);
        }
    //echo ('The language is valid');
    return new Response('The language is valid! Yes!');
    }*/
}
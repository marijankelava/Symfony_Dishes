<?php

namespace App\Services;

use App\Services\RequestDto;
use App\Entity\Language;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValidatorService 
{
    private ValidatorInterface $validatorInterface;

    public function __construct(
        ValidatorInterface $validatorInterface
        )
    {
        $this->validatorInterface = $validatorInterface;
    }

    public function validateLanguage($lang) :Response
    {
        //$language = new Language();

        //$language->setIsoCode($lang);

        $language = [];
;
        $errors = $this->validatorInterface->validate($language);

        if (count($errors) > 0) {
        
            $errorsString = (string) $errors;
            //echo $errorsString;

            return new Response($errorsString);
        }
    //echo ('The language is valid');
    return new Response('The language is valid! Yes!');
    }
}
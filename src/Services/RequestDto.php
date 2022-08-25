<?php

namespace App\Services;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class RequestDto
{
    /**
     * @Assert\NotBlank
     */
    private string $lang;

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }
}
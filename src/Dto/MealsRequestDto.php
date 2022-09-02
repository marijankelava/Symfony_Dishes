<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class MealsRequestDto
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
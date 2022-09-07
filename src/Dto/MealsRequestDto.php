<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class MealsRequestDto
{
    /**
     * @Assert\NotBlank
     */
    private string $lang;

    /**
     * @Assert\Type(type="digit")
     */
    private string $per_page;


    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function setPer_page(string $per_page): self
    {
        $this->per_page = $per_page;

        return $this;
    }
}
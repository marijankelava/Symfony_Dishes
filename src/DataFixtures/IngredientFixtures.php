<?php

namespace App\DataFixtures;

use App\Entity\Ingridient;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 19; $i++) {
            ${'ingridient' . $i} = new Ingridient();
            ${'ingridient' . $i}->setSlug('ingridient-' .  $i);
            $manager->persist(${'ingridient' . $i});

            $manager->flush();

            $this->addReference('ingridient_' . $i, ${'ingridient' . $i});
        }
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 4; $i++) {
            ${'category' . $i} = new Category();
            ${'category' . $i}->setSlug('category-' .  $i);
            $manager->persist(${'category' . $i});

            $manager->flush();

            $this->addReference('category_' . $i, ${'category' . $i});
        }
    }
}
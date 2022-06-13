<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 4; $i++) {
            ${'tag' . $i} = new Tag();
            ${'tag' . $i}->setSlug('tag-' .  $i);
            $manager->persist(${'tag' . $i});

            $manager->flush();

            $this->addReference('tag_' . $i, ${'tag' . $i});
        }
    }
}
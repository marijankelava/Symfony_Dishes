<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $language  = new Language();
        $language->setTitle('English');
        $language->setIsoCode('en');
        $manager->persist($language);

        $language2  = new Language();
        $language2->setTitle('Hrvatski');
        $language2->setIsoCode('hr');
        $manager->persist($language2);

        $manager->flush();

        $this->addReference('language_1', $language);
        $this->addReference('language_2', $language2);

    }
}
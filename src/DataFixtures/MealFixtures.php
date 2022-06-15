<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use App\DataFixtures\TagFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MealFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 15; $i++) {
            ${'meal' . $i} = new Meal();
            ${'meal' . $i}->setSlug('meal-' .  $i);
            /*${'meal' . $i}->addCategory($this->getReference('category_' . mt_rand(1, 3)));
            ${'meal' . $i}->addTag($this->getReference('tag_' . mt_rand(1, 3)));
            ${'meal' . $i}->addIngridient($this->getReference('ingridient_' . mt_rand(1, 11)));
            ${'meal' . $i}->addIngridient($this->getReference('ingridient_' . mt_rand(1, 11)));
            ${'meal' . $i}->addIngridient($this->getReference('ingridient_' . mt_rand(1, 11)));
            ${'meal' . $i}->addIngridient($this->getReference('ingridient_' . mt_rand(1, 11)));*/

            $this->addReference('meal_' . $i, ${'meal' . $i});

            $manager->persist(${'meal' . $i});

            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            TagFixtures::class
        ];
    }
}
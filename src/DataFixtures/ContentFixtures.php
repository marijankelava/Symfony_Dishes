<?php

namespace App\DataFixtures;

use App\Entity\Content;
use App\Entity\Meal;
use App\Entity\Category;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\MealRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\DataFixtures\MealFixtures;
use App\DataFixtures\TagFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ContentFixtures extends Fixture implements DependentFixtureInterface
{
    private $mealsRepository;
    private $categoryRepository;
    private $tagsRepository;

    public function __construct(
        MealRepository $mealsRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagsRepository
        )
    {
        $this->mealsRepository = $mealsRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagsRepository = $tagsRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $meals = $this->mealsRepository->findAll();

        $i = 0;
        foreach ($meals as $meal) {
            $content = new Content();
            $content->setEntityId($meal->getId());
            $content->setTitle('Meal '.$meal->getId().' EN');
            $content->setDescription('Meal '.$meal->getId().' Description');
            $content->setFqcn(Meal::class);
            $content->setLanguageId(1);
            
            $data = [1, 2, 3, 1, 2, 3, 1, 2, 3, 1, 2, 3, 1, 2, 3];
            $mealData = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
            $i++;

            $content->addTag($this->getReference('tag_' . $data[$i]));
            $content->addCategory($this->getReference('category_' . $data[$i]));
            $content->addIngridient($this->getReference('ingridient_' . $i));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 1)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 2)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 3)));

            $content->addLanguage($this->getReference('language_1'));

            $content->addMeal($this->getReference('meal_' . $mealData[$i]));
            
            $manager->persist($content);

            $manager->flush();    
        }

        $i = 0;
        foreach ($meals as $meal) {
            $content = new Content();
            $content->setEntityId($meal->getId());
            $content->setTitle('Jelo '.$meal->getId().' HR');
            $content->setDescription('Jelo '.$meal->getId().' Opis HR');
            $content->setFqcn(Meal::class);
            $content->setLanguageId(2);

            $data = [1, 2, 3, 1, 2, 3, 1, 2, 3, 1, 2, 3, 1, 2, 3];
            $i++;

            $content->addTag($this->getReference('tag_' . $data[$i]));
            $content->addCategory($this->getReference('category_' . $data[$i]));
            $content->addIngridient($this->getReference('ingridient_' . $i));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 1)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 2)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 3)));

            $content->addLanguage($this->getReference('language_2'));
            
            $manager->persist($content);

            $manager->flush();    
        }

        $categories = $this->categoryRepository->findAll();

        foreach ($categories as $category) {
            $content = new Content();
            $content->setEntityId($category->getId());
            $content->setTitle('Category '.$category->getId().' EN');
            $content->setFqcn(Category::class);
            $content->setLanguageId(1);

            $content->addLanguage($this->getReference('language_1'));
            
            $manager->persist($content);

            $manager->flush();    
        }

        foreach ($categories as $category) {
            $content = new Content();
            $content->setEntityId($category->getId());
            $content->setTitle('Kategorija '.$category->getId().' HR');
            $content->setFqcn(Category::class);
            $content->setLanguageId(2);

            $content->addLanguage($this->getReference('language_2'));
            
            $manager->persist($content);

            $manager->flush();    
        }

        $tags = $this->tagsRepository->findAll();

        foreach ($tags as $tag) {
            $content = new Content();
            $content->setEntityId($tag->getId());
            $content->setTitle('Tag '.$tag->getId().' EN');
            $content->setFqcn(Tag::class);
            $content->setLanguageId(1);

            $content->addLanguage($this->getReference('language_1'));
            
            $manager->persist($content);

            $manager->flush();    
        }

        foreach ($tags as $tag) {
            $content = new Content();
            $content->setEntityId($tag->getId());
            $content->setTitle('Tag '.$tag->getId().' HR');
            $content->setFqcn(Tag::class);
            $content->setLanguageId(2);

            $content->addLanguage($this->getReference('language_2'));
            
            $manager->persist($content);

            $manager->flush();    
        }
    }

    public function getDependencies()
    {
        return [
            MealFixtures::class,
        ];
    }
}
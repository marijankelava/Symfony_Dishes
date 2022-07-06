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
use App\Entity\Ingridient;
use App\Repository\IngridientRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ContentFixtures extends Fixture implements DependentFixtureInterface
{
    private $mealsRepository;
    private $categoryRepository;
    private $tagsRepository;
    private $ingridientRepository;

    public function __construct(
        MealRepository $mealsRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagsRepository,
        IngridientRepository $ingridientRepository
        )
    {
        $this->mealsRepository = $mealsRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagsRepository = $tagsRepository;
        $this->ingridientRepository = $ingridientRepository;
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
            $mealData = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
            $i++;

            $content->addTag($this->getReference('tag_' . $data[$i]));
            $content->addCategory($this->getReference('category_' . $data[$i]));
            $content->addIngridient($this->getReference('ingridient_' . $i));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 1)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 2)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 3)));

            $content->addLanguage($this->getReference('language_1'));

            $content->addMeal($this->getReference('meal_' . $mealData[$i]));
            //dd($content);
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
            $mealData = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
            $i++;

            $content->addTag($this->getReference('tag_' . $data[$i]));
            $content->addCategory($this->getReference('category_' . $data[$i]));
            $content->addIngridient($this->getReference('ingridient_' . $i));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 1)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 2)));
            $content->addIngridient($this->getReference('ingridient_' . ($i + 3)));

            $content->addLanguage($this->getReference('language_2'));

            $content->addMeal($this->getReference('meal_' . $mealData[$i]));
            
            $manager->persist($content);

            $manager->flush();    
        }

        $categories = $this->categoryRepository->findAll();

        $i = 0;

        foreach ($categories as $category) {
            $content = new Content();
            $content->setEntityId($category->getId());
            $content->setTitle('Category '.$category->getId().' EN');
            $content->setFqcn(Category::class);
            $content->setLanguageId(1);

            $data = [0, 1, 2, 3];
            $i++;

            $content->addLanguage($this->getReference('language_1'));
            $content->addCategory($this->getReference('category_'. $data[$i]));
            
            $manager->persist($content);

            $manager->flush();    
        }
        
        $i = 0;

        foreach ($categories as $category) {
            $content = new Content();
            $content->setEntityId($category->getId());
            $content->setTitle('Kategorija '.$category->getId().' HR');
            $content->setFqcn(Category::class);
            $content->setLanguageId(2);

            $data = [0, 1, 2, 3];
            $i++;

            $content->addLanguage($this->getReference('language_2'));
            $content->addCategory($this->getReference('category_'. $data[$i]));
            
            $manager->persist($content);

            $manager->flush();    
        }

        $tags = $this->tagsRepository->findAll();

        $i = 0;

        foreach ($tags as $tag) {
            $content = new Content();
            $content->setEntityId($tag->getId());
            $content->setTitle('Tag '.$tag->getId().' EN');
            $content->setFqcn(Tag::class);
            $content->setLanguageId(1);

            $data = [0, 1, 2, 3];
            $i++;

            $content->addLanguage($this->getReference('language_1'));
            $content->addTag($this->getReference('tag_'. $data[$i]));
            
            $manager->persist($content);

            $manager->flush();    
        }

        $i = 0;

        foreach ($tags as $tag) {
            $content = new Content();
            $content->setEntityId($tag->getId());
            $content->setTitle('Tag '.$tag->getId().' HR');
            $content->setFqcn(Tag::class);
            $content->setLanguageId(2);

            $data = [0, 1, 2, 3];
            $i++;

            $content->addLanguage($this->getReference('language_2'));
            $content->addTag($this->getReference('tag_'. $data[$i]));
            
            $manager->persist($content);

            $manager->flush();    
        }

        $ingridients = $this->ingridientRepository->findAll();

        $i = 0;

        foreach ($ingridients as $ingridient) {
            $content = new Content();
            $content->setEntityId($ingridient->getId());
            $content->setTitle('Ingridient '.$ingridient->getId().' EN');
            $content->setFqcn(Ingridient::class);
            $content->setLanguageId(1);

            $data = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
            $i++;

            $content->addLanguage($this->getReference('language_1'));
            $content->addIngridient($this->getReference('ingridient_' . $data[$i]));

            $manager->persist($content);

            $manager->flush();    
        }

        $i = 0;

        foreach ($ingridients as $ingridient) {
            $content = new Content();
            $content->setEntityId($ingridient->getId());
            $content->setTitle('Ingridient '.$ingridient->getId().' HR');
            $content->setFqcn(Ingridient::class);
            $content->setLanguageId(1);

            $data = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
            $i++;

            $content->addLanguage($this->getReference('language_2'));
            $content->addIngridient($this->getReference('ingridient_' . $data[$i]));
            
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
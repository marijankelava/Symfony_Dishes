<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use App\Repository\CategoryRepository;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $mealRepository;
    private $categoryRepository;
    private $contentRepository;

    public function __construct(
        MealRepository $mealRepository, 
        CategoryRepository $categoryRepository, 
        ContentRepository $contentRepository)
    {
        $this->mealRepository = $mealRepository;
        $this->categoryRepository = $categoryRepository;
        $this->contentRepository = $contentRepository;
    }

    /**
     * @Route("/", name="home", defaults={"name" = null}, methods={"GET"})
     */
    public function index(): Response
    {
        //$meals = $this->mealRepository->findAll();
        $categories = $this->contentRepository->showCategories();
        $meals = [];

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'meals' => $meals
        ]);
    }
}
 
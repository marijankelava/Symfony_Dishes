<?php

namespace App\Controller;
use App\Repository\CategoryRepository;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private MealRepository $mealRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        MealRepository $mealRepository, 
        CategoryRepository $categoryRepository)
    {
        $this->mealRepository = $mealRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/category/{id}", name="category", defaults={"name" = null}, methods={"GET", "HEAD"})
     */
    public function index($id) : Response
    {
        $categories = $this->categoryRepository->getMealCategories($id);
        $meals = $this->mealRepository->findByCategoryId($id);
        dd($categories);
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'meals' => $meals
        ]);
    }
}

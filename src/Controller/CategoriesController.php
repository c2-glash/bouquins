<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function pageCategories(CategorieRepository $repository)
    {
        return $this->render('categories/categories.html.twig', [
            'liste_categories' => $repository->findAll(),
        ]);
    }


}

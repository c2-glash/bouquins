<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OpenLibrarySearchController extends AbstractController
{
    /**
     * @Route("/openlibrary", name="open_library")
     */
    public function index()
    {
        return $this->render('open_library/openlibrarysearch.html.twig', [
            'controller_name' => 'OpenLibrarySearchController',
        ]);
    }
}

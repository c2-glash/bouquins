<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;

use function PHPSTORM_META\map;

class CompteController extends AbstractController
{
    /**
     * @Route("/meslivres", name="meslivres")
     */
    public function mesLivres()
    {
        return $this->render('compte/meslivres.html.twig');
    }
    
    /**
     * @Route("/mesemprunts", name="mesemprunts")
     */
    public function mesEmprunts()
    {
        return $this->render('compte/mesemprunt.html.twig');
    }
}
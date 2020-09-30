<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;

use function PHPSTORM_META\map;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte/meslivres", name="meslivres")
     */
    public function mesLivres()
    {
        return $this->render('compte/meslivres.html.twig');
    }
    
    /**
     * @Route("/compte/mesemprunts", name="mesemprunts")
     */
    public function mesEmprunts()
    {
        return $this->render('compte/mesemprunt.html.twig');
    }

    /**
     * @Route("/compte/mesprets", name="mesprets")
     */
    
     public function mesPrets()
    {
        return $this->render('compte/mesprets.html.twig');
    }
}